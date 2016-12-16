<?php

namespace App\Http\Controllers;

use App\College;
use App\Company;
use App\Course;
use App\InternshipSemester;
use App\Requirement;
use App\Student;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function __construct(){
        $Courses            = Course::get()->lists('course_desc', 'id')->all();
        $Colleges           = College::get()->lists('college_desc', 'id')->all();
        $Companies          = Company::orderBy('company_name')->get()->lists('company_name', 'id')->all();
        $InternshipSemesters = InternshipSemester::all()->lists('description', 'id')->all();

        $Requirements = Requirement::orderBy('order_seq')->get();

        view()->share(compact(['Courses','Colleges','Companies','Requirements','InternshipSemesters']));
    }

    public function classRecord()
    {
        return view('uploads.class_record', compact([

        ]));
    }

    public function uploadClassRecord(Request $request){
        if ( $request->hasFile('file') ) {
            $File = $request->file('file');
            Excel::load($File, function ($reader) use ($request) {
                //$reader->dd();
                $reader->each(function($sheet) use ($request)  {
                    $data = $sheet->toArray();

                    $student_no = trim(str_pad($data['student_no'],7,0,STR_PAD_LEFT),"\xC2\xA0");
                    $Student = Student::whereStudentNo($student_no)->first();

                    if ( $Student == null ) {

                        if ( !empty( $data['student_name'] ) ) {
                            Student::create([
                                'student_no' => $student_no,
                                'student_name' => $data['student_name'],
                                'course_id' => $request->input('course_id'),
                                'college_id' => $request->input('college_id'),
                                'internship_taken_id' => $request->input('internship_taken_id'),
                                'internship_enrolled_id' => $request->input('internship_enrolled_id'),
                                'section' => $request->input('section')
                            ]);
                        }

                    }



                });
            });
        }

        return redirect("uploads/class-record");
    }
}
