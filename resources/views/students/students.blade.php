@extends('home')
@section('body')
    <style>
        table tbody ul{
            list-style: none;
        }
        table tbody ul li{

        }
    </style>
    {!! Form::open([ 'url' => 'student/search' ]) !!}
        <div class="form-group row">
            <div class="col-sm-offset-8 col-sm- 4">
                <div class="input-group">
                    <input type="text" class="form-control" name="keyword" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" name="submit_btn" value="search">Go!</button>
                </span>
                </div><!-- /input-group -->
            </div>

        </div>

        <div class="panel">
            <table class="table table-hover">
                <thead>
                <tr>
                    <td>Student Name</td>
                    <td>College</td>
                    <td>Course</td>
                    <td class="text-center">Completed</td>
                </tr>
                </thead>
                <tbody>
                @foreach( $Students as $Student )
                    <tr onclick="window.location.href='{{ url("student/$Student->id/edit") }}'">
                        <td>
                            <strong>{{ $Student->student_name }}</strong>
                            <ul>
                                @foreach($Student->companies as $Company)
                                    <li><small>{{ $Company->company_name }}</small></li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $Student->college->college_desc }}</td>
                        <td>{{ $Student->course->course_desc }}</td>
                        <td class="text-center">{!! $Student->completed !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    {!! Form::close() !!}

@stop