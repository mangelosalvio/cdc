@extends('report')
@section('body')
    <style>

        table td{
            font-family: "Roboto", Helvetica, Arial, sans-serif;
            border: 1px solid #000;
            padding: 1px 3px;
            font-size: 10px;
        }
        table thead td{
            font-weight: bold;
        }
        div.caption {
            font-weight: bold;
            color:#000;
            text-align: center;
            font-size: 14px;
        }
        div.caption small{
            font-size: 9px;
            line-height: 10px;
            font-weight: normal;
        }
    </style>

    <div class="caption">
        Students Requested to Attend the <br>
        <span style="font-size: 30px;">JobStreet Seminar</span> <br>
        December 7, 2015 | 8AM-12PM | MM Audi A/B
    </div>
    <table align="center">
        <thead>
        <tr>
            <td>#</td>
            <td>Student No</td>
            <td>Student Name</td>
            <td>Course</td>
            <!-- <td>Contact No.</td> -->
        </tr>
        </thead>
        <tbody>
        @foreach($Students as $i=> $Student)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $Student->student_no }}</td>
                <td>{{ $Student->student_name }}</td>
                <td>{{ $Student->course->course_desc }}</td>
                <!-- <td>{{ $Student->contact_no }}</td> -->
            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="font-size:14px; text-align: center; font-family: Consolas, monospace; margin-top:14px;">
        JobStreet Sign-up link https://goo.gl/MexX03
    </div>
    <div class="caption">
        <small>
            If your name is on the list and you attended the Seniors Exit Seminar or have a class on the schedule, Please see Mr. Salvio at the Internship Office
            <br>
            Students who attended the Senior's Exit Seminar last September 26, 2015 are not required to attend the event
            <br>
            <span>Penalties will be imposed</span>
        </small>
    </div>
@endsection