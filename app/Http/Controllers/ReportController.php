<?php

namespace App\Http\Controllers;

use App\College;
use App\Company;
use App\Course;
use App\Event;
use App\InternshipSemester;
use App\MoaCategory;
use App\Registration;
use App\Requirement;
use App\Student;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use LynX39\LaraPdfMerger\Facades\PdfMerger;

class ReportController extends Controller
{
    public function __construct()
    {
        $Courses            = Course::get()->lists('course_desc', 'id')->all();
        $Colleges           = College::get()->lists('college_desc', 'id')->all();
        $Companies          = Company::orderBy('company_name')->get()->lists('company_name', 'id')->all();
        $InternshipSemesters = InternshipSemester::all()->lists('description', 'id')->all();
        $Events = Event::get()->lists('event_desc', 'id')->all();

        $Requirements = Requirement::orderBy('order_seq')->get();

        view()->share(compact(['Courses','Colleges','Companies','Requirements','InternshipSemesters','Events']));
    }
    public function studentInterns()
    {
        $course_id = $company_id = $internship_taken_id =
        $section = $internship_enrolled_id = null;

        return view('reports.student_interns_report', compact([
            'course_id',
            'company_id',
            'internship_taken_id',
            'internship_enrolled_id',
            'section'
        ]));
    }

    public function searchStudentInterns(Request $request)
    {
        $messages = [
            'course_id.required' => "Please select a course"
        ];
        $this->validate($request,[
            'course_id' => 'required'
        ], $messages);


        $course_id = $request->input('course_id',null);
        $company_id = $request->input('company_id',null);
        $internship_taken_id = $request->input('internship_taken_id',null);
        $internship_enrolled_id = $request->input('internship_enrolled_id',null);
        $section = $request->input('section',null);


        $Data = $request->all();

        $Data['internship_taken_id'] = ( $Data['internship_taken_id'] ) ? $Data['internship_taken_id'] : 0;
        $Data['internship_enrolled_id'] = ( $Data['internship_enrolled_id'] ) ? $Data['internship_enrolled_id'] : 0;
        $Data['company_id'] = ( $Data['company_id'] ) ? $Data['company_id'] : 0;



        return view('reports.student_interns_report', compact([
            'request',
            'Data',
            'course_id',
            'company_id',
            'internship_taken_id',
            'internship_enrolled_id',
            'section'
        ]));
    }

    public function printStudentInterns(Request $request,$course_id, $internship_taken_id = null, $internship_enrolled_id = null, $company_id = null){

        $Course = Course::find($course_id);
        $Students = Student::whereCourseId($course_id);

        $section = $request->get('section');

        if ( !empty( $internship_taken_id ) ) $Students->whereInternshipTakenId($internship_taken_id);
        if ( !empty( $internship_enrolled_id ) ) $Students->whereInternshipEnrolledId($internship_enrolled_id);
        if ( !empty( $section ) ) $Students->whereSection($section);

        //$Students->where('total_hours','<',450);

        $Students = $Students->orderBy('student_name')->get();

        $Students->each(function($Student){
            $Student->completed = $this->hasCompleted($Student->id) ? "YES" :  "NO";
            $Student->total_hours = $this->getTotalHours($Student);

            if ( $Student->grade ) {
                $Student->eq_grade = $this->disvertGrade(round($Student->grade->final_grade,0));
            } else {
                $Student->eq_grade = $this->disvertGrade(round($Student->final_grade,0));
            }


        });

        if ( $company_id ) {
            $Students = $Students->filter(function($Student) use ($company_id){

                if ($Student->companies()->find($company_id) ){
                    return true;
                } else {
                    return false;
                }
            });

        }

        return view('reports.print_student_interns', compact(['Students','Course']));
    }

    public function hasCompleted($id)
    {
        $requirements_count = Requirement::all()->count();

        if ( Student::find($id)->companies()->count() <= 0 ) return false;

        foreach( Student::find($id)->companies as $Company ){
            if ( $Company->pivot->requirements->count() < $requirements_count ) {
                return false;
            }
        };

        return true;
    }

    public function getTotalHours(Student $Student){
        $total_hrs = 0;
        if ( count( $Student->companies ) ){
            foreach ($Student->companies as $Company){
                if ( count($Company->pivot->dtrs) ) {
                    foreach ( $Company->pivot->dtrs as $DTR ) {
                        $total_hrs += $DTR->no_of_hrs;
                    }
                }

            }
        }

        return $total_hrs;

    }

    public function companyListing()
    {
        return view('reports.company_list_report');
    }

    public function searchCompanyListing(Request $request)
    {
        $messages = [
            'college_id.required' => "Please select a College"
        ];
        $this->validate($request,[
            'college_id' => 'required'
        ], $messages);

        $college_id = $request->input('college_id');
        $url = "reports/print-company-list?college_id=" . $request->input('college_id');


        return view('reports.company_list_report', compact(['request','url','college_id']));
    }

    public function printCompanyListing(Request $request){


        $College = College::find($request->get('college_id'));

        return view('reports.print_company_list_report', compact(['College']));
    }

    public function moaListing()
    {
        return view('reports.moa_list_report');
    }

    public function searchMoaListing(Request $request)
    {

        $college_id = $request->input('college_id');
        $url = "reports/print-moa-list?college_id=" . $request->input('college_id');


        return view('reports.moa_list_report', compact(['request','url','college_id']));
    }

    public function printMoaListing(Request $request){

        if ( $request->has('college_id') ) {
            $Colleges = College::whereId($request->get('college_id'))
                ->with('companies.moaCategory')->get();
        } else {
            $Colleges = College::with('companies.moaCategory')->get();
        }



        foreach ($Colleges as &$College) {

            $MoaCategories = MoaCategory::all();
            foreach ( $MoaCategories as $MoaCategory ) {
                $MoaCategory->companies = $College->companies()->whereMoaCategoryId($MoaCategory->id)->orderBy('company_name')->get();
            }
            $College->categories = $MoaCategories;
        }


        return view('reports.print_moa_list_report', compact(['Colleges']));
    }


    public function disvertGrade($grade) {
        if($grade == '0' || $grade == '0.0') return '0.0';
        else if($grade == '100') return '1.0';
        else if($grade == '99') return '1.1';
        else if($grade == '98') return '1.2';
        else if($grade == '97') return '1.3';
        else if($grade == '96') return '1.4';
        else if($grade == '95') return '1.5';
        else if($grade == '94') return '1.6';
        else if($grade == '93') return '1.7';
        else if($grade == '92') return '1.8';
        else if($grade == '91') return '1.9';
        else if($grade == '90') return '2.0';
        else if($grade == '89') return '2.1';
        else if($grade == '88') return '2.2';
        else if($grade == '87') return '2.3';
        else if($grade == '86') return '2.4';
        else if($grade == '85') return '2.5';
        else if($grade == '84') return '2.6';
        else if($grade == '83') return '2.7';
        else if($grade == '82') return '2.8';
        else if($grade == '81') return '2.9';
        else if($grade == '80') return '3.0';
        else if($grade == '79') return '3.1';
        else if($grade == '78') return '3.2';
        else if($grade == '77') return '3.3';
        else if($grade == '76') return '3.4';
        else if($grade == '75') return '3.5';
        else if ( $grade < 75 ) return 5;
        else if($grade == '5.0' || $grade == '5') return '5.0';
        else return 0;
    }

    public function merge()
    {
        PdfMerger::addPDF('1.pdf', 'all');
        PdfMerger::addPDF('2.pdf', 'all');
        PdfMerger::merge('download','test.pdf','P');
    }

    /**
     * Site Visit Form
     */

    public function siteVisitForm()
    {
        $course_id = $company_id = $internship_taken_id =
        $section = $internship_enrolled_id = null;

        return view('reports.site_visit_form', compact([
            'course_id',
            'company_id',
            'internship_taken_id',
            'internship_enrolled_id',
            'section'
        ]));
    }

    public function searchSiteVisitForm(Request $request)
    {
        $messages = [
            'company_id.required' => "Please select a Company"
        ];
        $this->validate($request,[
            'company_id' => 'required'
        ], $messages);


        $course_id = $request->input('course_id',null);
        $company_id = $request->input('company_id',null);
        $internship_taken_id = $request->input('internship_taken_id',null);
        $internship_enrolled_id = $request->input('internship_enrolled_id',null);
        $section = $request->input('section',null);

        $url = url("reports/print-site-visit-form?course_id=$course_id&company_id=$company_id&internship_taken_id=$internship_taken_id&internship_enrolled_id=$internship_enrolled_id&section=$section");



        return view('reports.site_visit_form', compact([
            'request',
            'course_id',
            'company_id',
            'internship_taken_id',
            'internship_enrolled_id',
            'section',
            'url'
        ]));
    }

    public function printSiteVisitForm(Request $request){

        $course_id = $request->get('course_id');
        $internship_taken_id = $request->get('internship_taken_id');
        $internship_enrolled_id = $request->get('internship_enrolled_id');
        $section = $request->get('section');
        $company_id = $request->get('company_id');

        $Students = Company::find($company_id)->students();

        if ( !empty( $course_id ) ) $Students->whereCourseId($course_id);
        if ( !empty( $internship_taken_id ) ) $Students->whereInternshipTakenId($internship_taken_id);
        if ( !empty( $internship_enrolled_id ) ) $Students->whereInternshipEnrolledId($internship_enrolled_id);
        if ( !empty( $section ) ) $Students->whereSection($section);

        $Students = $Students->orderBy('student_name')->get();
        $Company = Company::find($company_id);

        return view('reports.print_site_visit_form', compact(['Students','Company']));
    }


    /**
     * EVENT ATTENDANCE REPORT
     */

    public function eventAttendance()
    {
        return view('reports.event_attendance_report');
    }

    public function searchEventAttendance(Request $request)
    {

        $this->validate($request,[
            'event_id' => 'required'
        ],[
            'event_id.required' => 'Please select an event'
        ]);

        $event_id = $request->input('event_id');
        $course = $request->input('course');

        $url = "reports/print-event-attendance?event_id=$event_id&course=$course";

        return view('reports.event_attendance_report', compact([
            'request','url','event_id','course'
        ]));
    }

    public function printEventAttendance(Request $request){

        $event_id = $request->input('event_id');
        $course = $request->input('course');


        $Registrations = Registration::whereEventId($event_id);

        if ( !empty( $course ) ) {
            $Registrations->where('course','like',"%$course%");
        }

        $Registrations = $Registrations->orderBy('student_name')->with('logs')->get();

        //dd($Registrations);

        return view('reports.print_event_attendance_report', compact(['Registrations']));
    }
}


