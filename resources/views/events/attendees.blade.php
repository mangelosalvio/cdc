@extends('home')
@section('body')
    {!! Form::open([
        'url' => '/events/uploadAttendees',
        'files' => true
    ]) !!}

    <div class="form-inline">
        <div class="form-group">
            {!! Form::file('file') !!}

            {!! Form::submit('Upload', [
            'class' => 'btn btn-default'
            ]) !!}
        </div>
    </div>


    <div class="row">
        <i>Columns in excel: name, student_no, course</i>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 1%;">#</th>
                <th>STUDENT NO</th>
                <th>NAME</th>
                <th>COURSE</th>
            </tr>
            <tbody>
            @foreach($Attendees as $i => $Attendee)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $Attendee->student_no }}</td>
                    <td>{{ $Attendee->student_name }}</td>
                    <td>{{ $Attendee->course }}</td>
                </tr>
            @endforeach
            </tbody>
            </thead>
        </table>

    </div>


    {!! Form::close() !!}
@stop