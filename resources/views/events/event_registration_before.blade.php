@extends('home')
@section('body')
    <style>
        .attendance-table td{
            font-size: .8vw;
        }
    </style>

    @if ( Session::has('msg') )
    <div class="row alert alert-danger alert-dismissable text-center" role="alert">
        <h3>
            {{ Session::get('msg') }}
        </h3>

    </div>
    @endif

    <h3>{{ $Event->event_desc }} <br/><small>{{ $Event->event_date->toFormattedDateString() }}</small></h3>

    <div class="row">

        <div class="col-xs-4">
            {!! Form::open([
            'url' => '/events/registration',
            'files' => true
            ]) !!}

                {!! Form::hidden('event_id',$Event->id) !!}
                <div class="form-group">
                    <label for="student_no">Student ID</label>
                    <input type="text" class="form-control" id="student_no" name="student_no" placeholder="ID No." value="{{ isset($student_no) ? $student_no : ''  }}" @if(!$display_form) autofocus="autofocus" @endif/>
                </div>

                @if($display_form)
                    <div class="form-group info">
                        <label for="student_name">Name</label>
                        <input type="text" class="form-control" id="student_name" name="student_name" placeholder="Name"
                                @if($display_form) autofocus="autofocus" @endif onkeypress="if ( event.keyCode == 13 ){ $('#contact_no').focus(); return false;}" />
                    </div>
                    <div class="form-group info">
                        <label for="contact_no">Contact No.</label>
                        <input type="text" class="form-control" id="contact_no" name="contact_no" placeholder="Contact No."
                               onkeypress="if ( event.keyCode == 13 ){ $('#email').focus(); return false;}"/>
                    </div>

                    <div class="form-group info">
                        <label for="college">College</label>
                        <select name="college" id="college" class="form-control">
                            @foreach($arr_colleges as $college)
                                <option>{{ $college }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group info">
                        <label for="course">Course</label>
                        <select name="course" id="course" class="form-control">
                            @foreach($arr_courses as $course)
                                <option>{{ $course }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group info">
                        <label for="email">E-mail Address</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                               onkeypress="if ( event.keyCode == 13 ){ $('#save_btn').click(); return false;}"/>
                    </div>
                @endif

            {!! Form::submit('Save/Check', [
                'class' => 'btn btn-primary',
                'id' => 'save_btn'
            ]) !!}

            {!! Form::close() !!}

            {!! Form::open([
            'url' => '/events/registration/export',
            'files' => true
            ]) !!}

                <br/>

                {!! Form::hidden('event_id',$Event->id) !!}

                {!! Form::submit('Export', [
                'class' => 'btn btn-default'
                ]) !!}

            {!! Form::close() !!}

            {!! Form::open([
            'url' => '/events/registration/import',
            'files' => true
            ]) !!}

            <br/><br/>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    Import Registration
                </div>
                <div class="panel-body">
                    {!! Form::file('file') !!}

                    {!! Form::hidden('event_id',$Event->id) !!}

                    {!! Form::submit('Upload', [
                    'class' => 'btn btn-default'
                    ]) !!}
                </div>
            </div>
            {!! Form::close() !!}

        </div>
        <div class="col-xs-8">
            <table class="table table-bordered attendance-table">
                <thead>
                <tr>
                    <td style="width:1%;">#</td>
                    <td>Student No</td>
                    <td>Name</td>
                    <td>College</td>
                    <td>Course</td>
                    <td>Contact No</td>
                    <td>Email</td>
                    <td>Time Registered</td>
                </tr>
                </thead>
                <tbody>
                @foreach($Registration as $i => $r)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $r->student_no }}</td>
                        <td>{{ $r->student_name }}</td>
                        <td>{{ $r->college }}</td>
                        <td>{{ $r->course }}</td>
                        <td>{{ $r->contact_no }}</td>
                        <td>{{ $r->email }}</td>
                        <td>{{ $r->time_in->toTimeString() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop