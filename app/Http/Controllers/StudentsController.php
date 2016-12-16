<?php

namespace App\Http\Controllers;

use App\College;
use App\Company;
use App\Course;
use App\Dtr;
use App\Evaluation;
use App\Grade;
use App\InternshipSemester;
use App\Requirement;
use App\Student;
use App\TpeCategories;
use App\TpeEvaluation;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use LynX39\LaraPdfMerger\Facades\PdfMerger;
use Mockery\CountValidator\Exception;
use Psy\Exception\FatalErrorException;

class StudentsController extends Controller
{

    public function __construct(){
        $Courses            = Course::get()->lists('course_desc', 'id')->all();
        $Colleges           = College::get()->lists('college_desc', 'id')->all();
        $Companies          = Company::orderBy('company_name')->get()->lists('company_name', 'id')->all();
        $InternshipSemesters = InternshipSemester::all()->lists('description', 'id')->all();

        $Requirements = Requirement::orderBy('order_seq')->get();

        view()->share(compact(['Courses','Colleges','Companies','Requirements','InternshipSemesters']));
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $Student = new Student();

        return view('students.students_edit',compact(['Student']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $id = $request->input('id');

        /**
         * check for file here
         */

        $document_filename = null;
        $document = $request->file("document_filename");
        $merge = $request->input('merge',0);


        if ( Student::find($id) != null && empty( $document ) ) {
            $document_filename = Student::find($id)->document_filename;
        }


        if ( !empty( $document ) ) {
            $document_filename = uniqid() . '.' . $document->getClientOriginalExtension();
            $document->move('documents', $document_filename);

            if  ( $merge ) {
                $old_filename = Student::find($id)->document_filename;
                $new_filename = $document_filename;

                PdfMerger::addPDF("documents/$old_filename",'all');
                PdfMerger::addPDF("documents/$new_filename",'all');
                PdfMerger::merge('file',"documents/$new_filename",'P');

            }
        }

        $messages = [
            'course_id.required' => 'Please select a course',
            'college_id.required' => 'Please select a college',
            'internship_taken_id.required' => 'Please select when internship was taken',
            'internship_enrolled_id.required' => 'Please select when internship was enrolled'
        ];

        $student_name_validation = 'required|unique:students';
        if ( isset( $id ) || $id == null ) {
            $student_name_validation .= ",id,$id";
        }

        $this->validate($request,[
            'student_name' => $student_name_validation,
            'course_id' => 'required',
            'college_id' => 'required',
            'internship_taken_id' => 'required',
            'internship_enrolled_id' => 'required'
        ], $messages);



        $Student = Student::firstOrCreate([
            'id' => $id
        ]);

        $Student->update([
            'student_name' => $request->input('student_name'),
            'student_no' => $request->input('student_no'),
            'college_id' => $request->input('college_id'),
            'course_id' => $request->input('course_id'),
            'contact_no' => $request->input('contact_no'),
            'email' => $request->input('email'),
            'internship_taken_id' => $request->input('internship_taken_id'),
            'internship_enrolled_id' => $request->input('internship_enrolled_id'),
            'remarks' => $request->input('remarks'),
            'no_of_events_given' => $request->input('no_of_events_given'),
            'no_of_events_attended' => $request->input('no_of_events_attended'),
            'penalty_hrs' => $request->input('penalty_hrs'),
            'penalty_remarks' => $request->input('penalty_remarks'),
            'section' => $request->input('section'),
            'document_filename' => $document_filename

        ]);

        $Student->attendance_grade = $this->solveAttendanceGrade($Student);
        $Student->save();

        $this->solveFinalGrade($Student);

        $company_id = $request->input('company_id');

        if ( !empty( $company_id ) ){
            $Student->companies()->attach($company_id);
        }

        $id = $Student->id;


        /**
         * Get Student Grades
         */

        $Grade = $Student->grade;

        if ( $Grade ) {
            $Grade->monitoring = $request->input('monitoring');
            $Grade->attendance = $request->input('attendance');
            $Grade->compliance_of_reports = $request->input('compliance_of_reports');
            $Grade->final_reports = $request->input('final_reports');
            $Grade->with_monitoring = $request->input('with_monitoring',0);

            $Grade->save();
            $this->solveGrade($Grade);
        } else {

            if (
                $request->input('attendance') ||
                $request->input('compliance_of_reports') ||
                $request->input('final_reports')
            ) {

                $Grade = new Grade([
                    'monitoring' => $request->input('monitoring'),
                    'attendance' => $request->input('attendance'),
                    'compliance_of_reports' => $request->input('compliance_of_reports'),
                    'final_reports' => $request->input('final_reports'),
                    'with_monitoring' => $request->input('with_monitoring',0)
                ]);

                $Grade = $Student->grade()->save($Grade);

                //dd($Grade->toArray());
                $this->solveGrade($Grade);
            }

        }

        return Redirect::to("student/$id/edit");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $Student = Student::find($id);
        $total_no_of_hrs = $this->getTotalHours($Student);
        $fg = $this->disvertGrade(round($Student->final_grade,0));

        return view('students.students_edit',compact([
            'Student',
            'total_no_of_hrs',
            'fg'
        ]));
    }

    private function solveFinalGrade(Student $Student){
        if ( $Student->tpe_average <= 0 ) {
            $Student->tpe_average = 60;
        }

        $final_grade = round( $Student->tpe_average * 0.5 + $Student->attendance_grade * 0.2 + $Student->requirements_grade * 0.3 ,2 );
        $Student->final_grade = $final_grade;
        $Student->save();
    }

    private function solveGrade(Grade $Grade){
        /**
         * total score are always 10
         */

        $Student = $Grade->student;

        $monitoring_grade = $this->getGradePercentage($Grade->monitoring,10);
        $attendance_grade = $this->getGradePercentage($Grade->attendance,10);
        $compliance_of_reports_grade = $this->getGradePercentage($Grade->compliance_of_reports,10);
        $final_reports_grade = $this->getGradePercentage($Grade->final_reports,10);


        /**
         * WITH MONITORING
         */

        if ( $Grade->with_monitoring ) {
            /**
             * MONITORING - 20%
             * ATTENDANCE - 10%
             * COMPLIANCE OF REPORTS - 20%
             * FINAL REPORTS 20%
             * TPE 30%
             */

            $final_grade =
                ( $monitoring_grade * 0.2 ) +
                ( $attendance_grade * 0.1 ) +
                ( $compliance_of_reports_grade * 0.2 ) +
                ( $final_reports_grade * 0.2 ) +
                ( $Student->tpe_average * 0.3 );

        } else {
            /**
             * ATTENDANCE - 10%
             * COMPLIANCE OF REPORTS - 30%
             * FINAL REPORTS 30%
             * TPE 30%
             */

            $final_grade =
                ( $attendance_grade * 0.1 ) +
                ( $compliance_of_reports_grade * 0.3 ) +
                ( $final_reports_grade * 0.3 ) +
                ( $Student->tpe_average * 0.3 );
        }

        $Grade->final_grade = $final_grade;
        $Grade->save();
    }

    private function getGradePercentage($raw_score, $total_score){
        if ( $raw_score / $total_score >= 0.6 ) {
            $grade = 37.5 + 62.5 * $raw_score / $total_score;
        } else {
            $grade = 60 + 25 * $raw_score / $total_score;
        }

        return $grade;
    }


    private function solveRequirementsGrade(Student $Student){
        $total_requirements = Requirement::get()->count() * $Student->companies()->count();
        $requirements_on_hand = 0;

        foreach ( $Student->companies as $Company ) {
            $requirements_on_hand += $Company->pivot->requirements()->count();
        }


        if ( $requirements_on_hand / $total_requirements >= 0.6 ) {
            $grade = 37.5 + 62.5 * $requirements_on_hand / $total_requirements;
        } else {
            $grade = 60 + 25 * $requirements_on_hand / $total_requirements;
        }

        return round($grade,2);
    }

    private function solveAttendanceGrade(Student $Student){
        if ( $Student->no_of_events_given <= 0 ){
            return  0;
        }

        if ( $Student->no_of_events_attended / $Student->no_of_events_given >= 0.6 ) {
            $grade = 37.5 + 62.5 * $Student->no_of_events_attended / $Student->no_of_events_given;
        } else {
            $grade = 60 + 25 * $Student->no_of_events_attended / $Student->no_of_events_given;
        }

        return round($grade,2);
    }

    private function getTPEAvg(Student $Student){
        $total = $c = 0;

        if ( count( $Student->companies ) ){
            foreach ($Student->companies as $Company){
                if ( count($Company->pivot->evaluations) ) {
                    foreach ( $Company->pivot->evaluations as $Evaluation ) {
                        $total += $Evaluation->rating;
                        $c++;
                    }
                }
            }
        }

        if ( $c <= 0 ) {
            return 0;
        } else {
            return round( $total / $c ,2);
        }
    }

    private function getTotalHours(Student $Student){
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

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function search( Request $request )
    {
        $Students = Student::where(function($query) use ( $request ){
            $query->where('student_no','like','%$'.$request->input('keyword').'%')
                ->orWhere('student_name','like','%'.$request->input('keyword').'%')
                ->orWhere('student_no','like','%'.$request->input('keyword').'%');
            })->with('college','course','companies')
            ->orderBy('student_name', 'asc')->get();


        $Students->each(function($Student){
            $Student->completed = $this->hasCompleted($Student->id) ? "<span class='btn btn-success'>Yes</span>" :  "<span class='btn btn-warning'>No</span>";
        });


        return view('students.students',compact([
            'Students'
        ]));
    }

    private function hasCompleted($id)
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

    public function delete($student_id)
    {
        Student::find($student_id)->delete();
        return Redirect::to("/");
    }

    public function deleteCompany($student_id, $company_id)
    {

        Student::find($student_id)
            ->companies()
            ->find($company_id)
            ->pivot
            ->requirements()
            ->detach();

        Student::find($student_id)
            ->companies()
            ->detach($company_id);



        return Redirect::to("student/$student_id/edit");
    }

    public function companyRequirements( Request $request )
    {



        $AllRequirements = Requirement::orderBy('order_seq')->get()->lists('id')->toArray();

        $RequirementsNotAchieved = array_diff($AllRequirements, $request->input('requirements'));

        $Requirements = Student::find( $request->input('student_id') )
            ->companies()
            ->find( $request->input('company_id') )
            ->pivot
            ->requirements();

        $Requirements->detach($RequirementsNotAchieved);

        $OldRequirements = $Requirements->orderBy('order_seq')
            ->get()
            ->lists('id')
            ->toArray();
        $NewRequirements = array_diff($request->input('requirements'), $OldRequirements);

        if ( count( $NewRequirements ) > 0 ) $Requirements->attach($NewRequirements);

        //dd($NewRequirements);
        $files = $request->file("attachments");
        $attachment_ids = $request->input('attachment_ids');


        //dd($files);
        //dd($request->input('requirements'));


        if ( count($attachment_ids) ) {
            foreach ($attachment_ids as $i => $id) {

                if (!empty($files[$i])) {

                    $filename = uniqid() . '.' . $files[$i]->getClientOriginalExtension();
                    $files[$i]->move('uploads', $filename);

                    $Req = Student::find($request->input('student_id'))
                        ->companies()
                        ->find($request->input('company_id'))
                        ->pivot
                        ->requirements()
                        ->find($id);


                    if ($Req != null) {
                        if (!empty($Req->pivot->ref)) {
                            Student::find($request->input('student_id'))
                                ->companies()
                                ->find($request->input('company_id'))
                                ->pivot
                                ->requirements()
                                ->updateExistingPivot($id, ['ref' => $filename]);

                            /*$Req->pivot->update(['ref' => $filename]);*/
                            /*dd($request->input('student_id')." ".$request->input('company_id')." ".$id. " ". $filename);*/
                        } else {
                            $Req->pivot->ref = $filename;
                            $Req->pivot->save();
                            $Req->save();
                        }

                    }

                }

            }
        }

        /**
         * Save Grade here
         */
        $Student = Student::find( $request->input('student_id') );
        $Student->requirements_grade = $this->solveRequirementsGrade(Student::find( $request->input('student_id') ));
        $Student->save();

        $this->solveFinalGrade($Student);

        return Redirect::to('student/'.$request->input('student_id').'/edit');
    }

    public function cpe(){
        $Students = Student::whereCourseId(2)->orderBy('student_name')->get();
        return view('reports.current',compact([
            'Students'
        ]));
    }

    public function companyDtr( Request $request ){
        $id = $request->input('student_id');

        if ( $request->has('from_date_dtr') && $request->has('to_date_dtr') &&
            $request->has('no_of_hrs')) {

            Student::findOrNew($request->input('student_id'))
                ->companies()
                ->find($request->input('company_id'))
                ->pivot
                ->dtrs()
                ->create([
                    'from_date_dtr' => $request->input('from_date_dtr'),
                    'to_date_dtr' => $request->input('to_date_dtr'),
                    'no_of_hrs' => $request->input('no_of_hrs')
                ]);
        }

        return Redirect::to("student/$id/edit");
    }

    public function dtrDelete($student_id, $dtr_id){
        Dtr::find($dtr_id)->delete();
        return Redirect::to("student/$student_id/edit");
    }

    public function getTPE($student_id, $company_id, $version){
        $Student = Student::find($student_id);
        $Company = Company::find($company_id);
        $TpeCategories = TpeCategories::with(['questions' => function($query) use ($version){
            $query->version($version);
        }])->get();

        $TpeQuestions = Evaluation::version($version)->get();

        return view('students.tpe', compact([
            'Student',
            'Company',
            'TpeCategories',
            'version',
            'TpeQuestions'
        ]));
    }

    public function storeTPE(Request $request, $student_id, $company_id, $version){
        if ( $version == 2 ) {
            $this->storeTPEVersion2($request, $student_id, $company_id, $version);
        } elseif ( $version == 1 ) {
            $this->storeTPEVersion1($request, $student_id, $company_id, $version);
        }

        return Redirect::to("student/$student_id/edit");
    }

    private function storeTPEVersion1($request, $student_id, $company_id, $version){
        $StudentEvaluation = $TPE = Student::find($student_id)
            ->companies()
            ->find($company_id)
            ->pivot
            ->evaluations()
            ->create($request->all());

        if( $request->has('arr_category_id') ){
            foreach ( $request->input('arr_category_id') as $i => $tpe_category_id ) {
                $StudentEvaluation->scores()
                    ->create([
                        'tpe_category_id' => $tpe_category_id,
                        'tpe_question_id' => $request->input('arr_question_id')[$i],
                        'tpe_score' => $request->input('arr_answer')[$i]
                    ]);
            }
        }

        $grade = 0;
        $TpeCategories = TpeCategories::all();
        foreach ( $TpeCategories as $c => $TpeCategory ) {
            $Evaluation = $StudentEvaluation->scores();
            $CategoryEval = $Evaluation->where('tpe_category_id',$TpeCategory->id)->get();

            if ( $CategoryEval->sum('tpe_score') / ( $CategoryEval->count() * 10 ) >= 0.6 ) {
                $category_grade = 37.5 + 62.5 * $CategoryEval->sum('tpe_score') / ( $CategoryEval->count() * 10 );
            } else {
                $category_grade = 60 + 25 * $CategoryEval->sum('tpe_score') / ( $CategoryEval->count() * 10 );
            }

            $grade += $category_grade * $TpeCategory->tpe_rate / 100;
        }


        $rating = $this->disvertGrade(round($grade,0));

        $TPE->rating = $grade;
        $TPE->save();



        /**
         * Update TPE Average
         */
        $Student = Student::find($student_id);
        $Student->tpe_average = $this->getTPEAvg($Student);
        $Student->save();

        $this->solveFinalGrade($Student);
    }

    private function storeTPEVersion2(Request $request, $student_id, $company_id, $version){
        $StudentEvaluation = $TPE = Student::find($student_id)
            ->companies()
            ->find($company_id)
            ->pivot
            ->evaluations()
            ->create($request->all());

        $c = 0;
        if( $request->has('arr_category_id') ){
            foreach ( $request->input('arr_category_id') as $i => $tpe_category_id ) {
                $answers = $request->input('arr_answer')[$i];
                if ( count($answers) ) {
                    foreach ( $answers as $answer ) {
                        $StudentEvaluation->scores()
                            ->create([
                                'tpe_category_id' => $tpe_category_id,
                                'tpe_question_id' => $request->input('arr_question_id')[$c],
                                'tpe_score' => $answer
                            ]);
                        $c++;
                    }
                }
            }
        }

        $grade = 0;
        $TpeCategories = TpeCategories::all();
        foreach ( $TpeCategories as $TpeCategory ) {
            $Evaluation = $StudentEvaluation->scores();
            $CategoryEval = $Evaluation->where('tpe_category_id',$TpeCategory->id)->get();
            $grade += round($CategoryEval->sum('tpe_score') / $CategoryEval->count() * $TpeCategory->tpe_rate / 100,2);
        }

        $rating = $this->invertGrade(round($grade,1));


        $TPE->rating = $rating;
        $TPE->save();

        /*dd($grade ." | ".$rating);*/

        /**
         * Update TPE Average
         */
        $Student = Student::find($student_id);
        $Student->tpe_average = $this->getTPEAvg($Student);
        $Student->save();

        $this->solveFinalGrade($Student);
    }

    private function invertGrade($grade) {
        if($grade == 0 || $grade == 0.0) return '0.0';
        else if($grade == '1.0' || $grade == '1') return '100';
        else if($grade == '1.1') return '99';
        else if($grade == '1.2') return '98';
        else if($grade == '1.3') return '97';
        else if($grade == '1.4') return '96';
        else if($grade == '1.5') return '95';
        else if($grade == '1.6') return '94';
        else if($grade == '1.7') return '93';
        else if($grade == '1.8') return '92';
        else if($grade == '1.9') return '91';
        else if($grade == '2.0' || $grade == '2') return '90';
        else if($grade == '2.1') return '89';
        else if($grade == '2.2') return '88';
        else if($grade == '2.3') return '87';
        else if($grade == '2.4') return '86';
        else if($grade == '2.5') return '85';
        else if($grade == '2.6') return '84';
        else if($grade == '2.7') return '83';
        else if($grade == '2.8') return '82';
        else if($grade == '2.9') return '81';
        else if($grade == '3.0' || $grade == '3') return '80';
        else if($grade == '3.1') return '79';
        else if($grade == '3.2') return '78';
        else if($grade == '3.3') return '77';
        else if($grade == '3.4') return '76';
        else if($grade == '3.5') return '75';
        else if($grade == '5.0' || $grade == '5' || $grade > 3.5) return '5.0';
    }
    private function disvertGrade($grade) {
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

    public function cs(){
        $Students = Course::find(18)
            ->students()
            ->whereInternshipEnrolledId('3')
            ->get();

        return view('students.cs', compact([
            'Students'
        ]));
    }

    public function seminar(){
        $Students = Student::whereCollegeId(1)
            ->whereInternshipTakenId(1)
            ->whereInternshipEnrolledId(3)
            ->whereIn('course_id',[2,3,4,5])
            ->whereNotNull('student_no')
            ->where('student_no','!=','')
            ->whereNotIn('student_no', function($query){
                $query->select('student_no')
                    ->from('registration')
                    ->whereEventId(2);
            })
            ->orderBy('student_name')
            ->get();
        //dd($Students->toArray());
        return view('students.seminar',compact(['Students']));
    }

    public function test(){
        return view('test');
    }

    public function printRequirements($student_no){
        $Student = Student::whereStudentNo($student_no)
            ->first();

        return view('missing_requirements',compact('Student'));
    }

    public function deleteTpe($student_id, $tpe_id){
        TpeEvaluation::find($tpe_id)
            ->delete();

        return Redirect::to("student/$student_id/edit");
    }
}
