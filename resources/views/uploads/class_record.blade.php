@extends('home')
@section('body')
    {!! Form::open([
        'url' => '/uploads/class-record',
        'files' => true,
        'class' => 'form-horizontal'
    ]) !!}

    <div class="form-group form-group-sm">
        {!! Form::label("file", "File",
        [
            "class" => "control-label col-sm-2"
        ]) !!}

        <div class="col-md-10" >
            {!! Form::file('file') !!}
        </div>
    </div>

    <div class="form-group form-group-sm">
        {!! Form::label("college_id", "College",
        [
        "class" => "control-label col-sm-2"
        ]) !!}

        <div class="col-md-10" >
            {!! Form::select('college_id',
            $Colleges,
            null,
            [ "class" => "form-control"]
            ) !!}
        </div>
    </div>

    <div class="form-group form-group-sm">
        {!! Form::label("course_id", "Course",
        [
        "class" => "control-label col-sm-2"
        ]) !!}

        <div class="col-md-10" >
            {!! Form::select('course_id',
            [ '' => 'Select Course:' ]
            +
            $Courses,
            null,
            [ "class" => "form-control"]
            ) !!}
        </div>
    </div>

    <div class="form-group form-group-sm">
        {!! Form::label("internship_taken_id", "Internship Taken",
        [
        "class" => "control-label col-sm-2"
        ]) !!}

        <div class="col-md-10" >
            {!! Form::select('internship_taken_id',
            [ '' => 'Select Semester:' ] +
            $InternshipSemesters,
            null,
            [ "class" => "form-control"]
            ) !!}
        </div>
    </div>

    <div class="form-group form-group-sm">
        {!! Form::label("internship_enrolled_id", "Interhsip Enrolled",
        [
        "class" => "control-label col-sm-2"
        ]) !!}

        <div class="col-md-10" >
            {!! Form::select('internship_enrolled_id',
            [ '' => 'Select Semester:' ] +
            $InternshipSemesters,
            null,
            [ "class" => "form-control"]
            ) !!}
        </div>
    </div>

    <div class="form-group form-group-sm">
        {!! Form::label("section", "Section",
        [
        "class" => "control-label col-sm-2"
        ]) !!}

        <div class="col-md-10" >
            {!! Form::text("section", null,
            [
            "id" => "section",
            "class" => "form-control"
            ]) !!}

        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="col-md-offset-2 col-md-10">
            {!! Form::submit('Upload', [
                'class' => 'btn btn-primary'
            ]) !!}
        </div>
    </div>


    {!! Form::close() !!}
@stop