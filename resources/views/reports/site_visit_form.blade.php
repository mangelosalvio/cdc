@extends('home')
@section('body')
    {!! Input::old('course_id') !!}
    <div class="row">
        {!! Form::open([
            'url' => 'reports/site-visit-form',
             'class' => 'form-group-sm'
        ]) !!}

        <div class="form-group">
            {!! Form::label('course_id','Course') !!}
            {!! Form::select('course_id',
                [ '' => 'Select Course:' ]
                +
                $Courses,
                $course_id,
                [ "class" => "form-control"]
                ) !!}
        </div>
        <div class="form-group">
            {!! Form::label('company_id','Company') !!}
            {!! Form::select('company_id',
                [ '' => 'Select Company:' ]
                +
                $Companies,
                $company_id,
                [ "class" => "form-control"]
                ) !!}
        </div>

        <div class="form-group">
            {!! Form::label('internship_taken_id', 'Internship Taken') !!}
            {!! Form::select('internship_taken_id',
                [ '' => 'Select Semester:' ] +
                $InternshipSemesters,
                $internship_taken_id,
                [ "class" => "form-control"]
                ) !!}
        </div>

        <div class="form-group">
            {!! Form::label('internship_enrolled_id', 'Internship Enrolled') !!}
            {!! Form::select('internship_enrolled_id',
                [ '' => 'Select Semester:' ] +
                $InternshipSemesters,
                $internship_enrolled_id,
                [ "class" => "form-control"]
                ) !!}
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("section", "Section",
            [
            "class" => "control-label"
            ]) !!}


                {!! Form::text("section", $section,
                [
                "id" => "section",
                "class" => "form-control"
                ]) !!}


        </div>

        <div class="form-group">
            {!! Form::submit('Search',[
                'class' => 'form-control'
            ]) !!}
        </div>

        <input type="button" class="form-control" value="Print" onclick="printIframe('JOframe');"/>

        {!! Form::close() !!}
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger" style="margin:20px 0px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if( isset($url) )
    <div class="row" style="margin:20px 0px;">
        <iframe id="JOframe" src="{!! $url !!}" frameborder="0" style="width:100%; height:400px;"></iframe>
    </div>
    @endif
@endsection