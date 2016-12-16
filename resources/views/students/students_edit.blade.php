@extends('home')
@section('body')
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
    {!! Form::close() !!}

    {!! Form::model($Student, array('url' => 'student', 'class' => 'form-horizontal', 'files' => true)) !!}

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group gorm-group-sm">
            {!! Form::label("document_filename", "Documents",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::file('document_filename',array('style' => "display:inline-block;")) !!}

                @if( isset( $Student->document_filename ) )
                <a target="_blank" href=" {{ url("/documents/". $Student->document_filename ) }}" style="display: inline-block;">
                    <span class="glyphicon glyphicon-new-window" aria-hidden="true" style="color: #03A9F4;"></span>
                </a>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="merge" value="1"> Merge
                    </label>
                </div>
                @endif

            </div>

        </div>

        <div class="panel panel-info">
            <div class="panel-heading"><strong>Student Information</strong></div>
            <div class="panel-body">
                <div class="form-group form-group-sm">
                    {!! Form::label("student_name", "Student Name",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-md-10" >
                        {!! Form::text("student_name", null,
                        [
                        "id" => "student_name",
                        "class" => "form-control",
                        ]) !!}

                        {!! Form::hidden('id') !!}
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    {!! Form::label("student_no", "Student No",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-md-10" >
                        {!! Form::text("student_no", null,
                        [
                        "id" => "student_no",
                        "class" => "form-control"
                        ]) !!}

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
                    {!! Form::label("contact_no", "Contact No.",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-md-10" >
                        {!! Form::text("contact_no", null,
                        [
                        "id" => "contact_no",
                        "class" => "form-control"
                        ]) !!}
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    {!! Form::label("email", "Email",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-md-10" >
                        {!! Form::text("email", null,
                        [
                        "id" => "email",
                        "class" => "form-control"
                        ]) !!}
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label("remarks", "Remarks",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-md-10" >
                        {!! Form::textarea("remarks", null,
                        [
                        "id" => "remarks",
                        "class" => "form-control",
                       'rows' => 3
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-info">
            <div class="panel-heading"><strong>Grade</strong></div>
            <div class="panel-body">
                <div class="form-group form-group-sm">
                    {!! Form::label("monitoring", "Monitoring",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-md-10" >
                        {!! Form::text("monitoring",  ($Student->grade) ? $Student->grade->monitoring : '' ,
                        [
                        "id" => "monitoring",
                        "class" => "form-control"
                        ]) !!}
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    {!! Form::label("attendance", "Attendance",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-md-10" >
                        {!! Form::text("attendance", ($Student->grade) ? $Student->grade->attendance : '' ,
                        [
                        "id" => "attendance",
                        "class" => "form-control"
                        ]) !!}
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    {!! Form::label("compliance_of_reports", "Compliance of Reports",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-md-10" >
                        {!! Form::text("compliance_of_reports", ($Student->grade) ? $Student->grade->compliance_of_reports : '' ,
                        [
                        "id" => "compliance_of_reports",
                        "class" => "form-control"
                        ]) !!}
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    {!! Form::label("final_reports", "Final Reports",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-md-10" >
                        {!! Form::text("final_reports", ($Student->grade) ? $Student->grade->final_reports : '' ,
                        [
                        "id" => "final_reports",
                        "class" => "form-control"
                        ]) !!}
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    {!! Form::label("with_monitoring", "With Monitoring",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-md-10" >
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox("with_monitoring", 1, isset($Student->grade) ? $Student->grade->with_monitoring == 1: false ,
                                [
                                "id" => "with_monitoring",
                                ]) !!}
                            </label>

                        </div>

                    </div>
                </div>

                <div class="form-group form-group-sm">
                    {!! Form::label("final_reports", "Final Grade",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-md-10" >
                        <h3>
                        {{ ($Student->grade) ? $Student->grade->final_grade : '' }}
                        </h3>

                    </div>
                </div>
            </div>
        </div>

        <hr>
    
        <div class="form-group form-group-sm">
            {!! Form::label("penalty_hrs", "Penalty Hrs",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::text("penalty_hrs", null,
                [
                "id" => "penalty_hrs",
                "class" => "form-control"
                ]) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label("penalty_remarks", "Penalty Remarks",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::textarea("penalty_remarks", null,
                [
                "id" => "penalty_remarks",
                "class" => "form-control",
               'rows' => 3
                ]) !!}
            </div>
        </div>

        <hr>

        <div class="form-group form-group-sm">
            {!! Form::label("total_no_of_hrs", "Total Hrs",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::text("total_no_of_hrs", ( isset($total_no_of_hrs) ) ? $total_no_of_hrs : 0,
                [
                "id" => "total_no_of_hrs",
                "class" => "form-control",
                'readonly' => 'readonly'
                ]) !!}
            </div>
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("no_of_events_given", "No of Events Given",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::text("no_of_events_given", null,
                [
                "id" => "no_of_events_given",
                "class" => "form-control"
                ]) !!}
            </div>
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("no_of_events_attended", "No of Events Attended",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::text("no_of_events_attended", null,
                [
                "id" => "no_of_events_attended",
                "class" => "form-control"
                ]) !!}
            </div>
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("attendance_grade", "Attendance Rating",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::text("attendance_grade", null,
                [
                "id" => "attendance_grade",
                "class" => "form-control",
                'readonly' => 'readonly'
                ]) !!}
            </div>
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("requirements_grade", "Requirements Rating",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::text("requirements_grade", null,
                [
                "id" => "requirements_grade",
                "class" => "form-control",
                'readonly' => 'readonly'
                ]) !!}
            </div>
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("tpe_average", "TPE Avg",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::text("tpe_average", null,
                [
                "id" => "tpe_average",
                "class" => "form-control",
                'readonly' => 'readonly'
                ]) !!}
            </div>
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("final_grade", "Final Grade",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::text("final_grade", null,
                [
                "id" => "final_grade",
                "class" => "form-control",
                'readonly' => 'readonly'
                ]) !!}
            </div>
        </div>


        <div class="form-group form-group-sm">
            {!! Form::label("final_grade_eq", "Final Grade Eq",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::text("final_grade_eq", ( isset($fg) ) ? $fg : 0 ,
                [
                "id" => "final_grade_eq",
                "class" => "form-control",
                'readonly' => 'readonly'
                ]) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::submit('Save', [
            'class' => 'btn btn-default'
            ]) !!}

            <a href="{{ url('student') }}" class="btn btn-default" >New</a>
            @if( isset($Student->id) )
                <a href="{{ url("student/$Student->id/delete") }}" class="btn btn-danger" >Delete</a>
            @endif
        </div>

    @if( isset($Student->id) )
        <div class="panel panel-primary">
            <div class="panel-heading">
                Company
            </div>
            <div class="panel-body">
                <div class="form-inline">
                    {!! Form::select('company_id',
                    array('' => 'Select Company') +
                    $Companies,
                    null,
                    [ "class" => "form-control"]
                    ) !!}

                    <button class="btn btn-default">Add</button>
                </div>

            </div>
        </div>
    @endif

    {!! Form::close() !!}

    @if( $Student->companies()->count() > 0 )
    <div>
        <table class="table">
            <thead>
            <tr>
                <td style="width:5%;"></td>
                <td>COMPANY NAME</td>
            </tr>
            </thead>
            <tbody>
            @foreach($Student->companies as $Company )
                <tr>
                    <td>
                        <a href="{{ url("student/".$Student->id."/company/".$Company->id."/delete") }}">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                    <td>{{ $Company->company_name }}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="row">
                                    {!! Form::open([
                                        'url' => 'student/company/requirements',
                                        'files' => true
                                    ]) !!}
                                    @foreach( $Requirements as $Requirement )
                                        <div class="checkbox">
                                            <div class="row">
                                                <div class="col-xs-5">
                                                    <label>
                                                        <input type="checkbox"
                                                               name="requirements[]"
                                                               @if( $Company->pivot->requirements()->find($Requirement->id) != null )
                                                               checked
                                                               @endif
                                                               value="{{ $Requirement->id }}" >
                                                        {{ $Requirement->requirement_desc }}
                                                        @if( isset($Company->pivot->requirements()->find($Requirement->id)->pivot->ref) )
                                                            <a target="_blank" href=" {{ url("/uploads/".$Company->pivot->requirements()->find($Requirement->id)->pivot->ref) }}">
                                                                <span class="glyphicon glyphicon-new-window" aria-hidden="true" style="color: #03A9F4;"></span>
                                                            </a>
                                                        @endif
                                                    </label>
                                                </div>
                                                <div class="col-xs-7">
                                                    @if( $Company->pivot->requirements()->find($Requirement->id) != null )
                                                        {!! Form::file('attachments[]', [ 'style' => 'display:inline-block; ']) !!}
                                                        {!! Form::hidden( 'attachment_ids[]', $Requirement->id ) !!}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="form-group">
                                        {!! Form::hidden('student_id',$Student->id) !!}
                                        {!! Form::hidden('company_id',$Company->id) !!}
                                        {!! Form::submit('Save',[
                                            'class' => 'btn btn-default'
                                        ]) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">Monthly DTR</div>
                                    <div class="panel-body">
                                        <div class="row">

                                            <div class="col-xs-12">
                                                {!! Form::open([
                                                   'url' => 'student/company/dtr',
                                                   'files' => true,
                                                   'class' => 'form-inline'
                                                ]) !!}
                                                <div class="form-group-sm">
                                                    <label class="sr-only" for="from_date_dtr">DTR From Date</label>
                                                    <input type="text" class="form-control datepicker"
                                                           style="width:100px;"
                                                           id="from_date_dtr" placeholder="From Date" name="from_date_dtr"
                                                           autofocus = "true"
                                                           onkeyup="if(event.keyCode == 13 ) $(this).next().next().focus(); return false;">

                                                    <label class="sr-only" for="to_date_dtr">DTR To Date</label>
                                                    <input type="text" class="form-control datepicker"
                                                           style="width:100px;"
                                                           id="to_date_dtr" placeholder="To Date" name="to_date_dtr"
                                                           onkeyup="if(event.keyCode == 13 ) $(this).next().next().focus(); return false;">

                                                    <label class="sr-only" for="no_of_hours">No of Hours</label>
                                                    <input type="text" class="form-control"
                                                           style="width:100px;"
                                                           id="no_of_hours" placeholder="No. of hrs" name="no_of_hrs">

                                                    <button type="submit" name="addDTR" class="btn btn-default">Add DTR</button>
                                                </div>
                                                {!! Form::hidden('company_id',$Company->id) !!}
                                                {!! Form::hidden('student_id',$Student->id) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <td style="width: 5%;"></td>
                                                <td>FROM DATE</td>
                                                <td>TO DATE</td>
                                                <td class="text-right"># OF HRS</td>
                                            </tr>
                                            </thead>
                                            @foreach($Company->pivot->dtrs()->orderBy('from_date_dtr')->get() as $DTR)
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <a href="{{ url("student/".$Student->id."/company/dtr/".$DTR->id."/delete") }}">
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        </a>
                                                    </td>
                                                    <td>{{ $DTR->from_date_dtr }}</td>
                                                    <td>{{ $DTR->to_date_dtr }}</td>
                                                    <td class="text-right">{{ $DTR->no_of_hrs }}</td>
                                                </tr>
                                                </tbody>
                                            @endforeach
                                            <tfoot>
                                            <tr>
                                                <td colspan="3" class="text-right">Total Hrs</td>
                                                <td style="font-weight: bold;" class="text-right">{{ $Company->pivot->dtrs()->sum('no_of_hrs') }}</td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>


                                <hr>

                                <div class="panel panel-primary">
                                    <div class="panel-heading clearfix">
                                        <span style="font-weight: bold;">OLD Trainees Performance Evaluation v1</span>

                                        <a style="float:right;" href="{{ url("student/tpe/".$Student->id."/".$Company->id .'/1') }}"><button class="btn btn-default">Add TPE</button></a>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <td>Date</td>
                                                <td>Rated By</td>
                                                <td>Position</td>
                                                <td style="text-align: right;">Rating</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Company->pivot->evaluations()->version(1)->get() as $Evaluation)
                                                <tr>
                                                    <td>{{ $Evaluation->date }}</td>
                                                    <td>{{ $Evaluation->rated_by }}</td>
                                                    <td>{{ $Evaluation->position }}</td>
                                                    <td style="text-align: right;">{{ $Evaluation->rating }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="panel panel-primary">
                                    <div class="panel-heading clearfix">
                                        <span style="font-weight: bold;">NEW Trainees Performance Evaluation v2</span>

                                        <a style="float:right;" href="{{ url("student/tpe/".$Student->id."/".$Company->id .'/2') }}"><button class="btn btn-default">Add TPE</button></a>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <td></td>
                                                <td>Date</td>
                                                <td>Rated By</td>
                                                <td>Position</td>
                                                <td style="text-align: right;">Rating</td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Company->pivot->evaluations()->version(2)->get() as $Evaluation)
                                                <tr>
                                                    <td>
                                                        <a href="{{ url("student/".$Student->id."/tpe/".$Evaluation->id."/delete") }}">
                                                            <span class="glyphicon glyphicon-remove"></span>
                                                        </a>
                                                    </td>
                                                    <td>{{ $Evaluation->date }}</td>
                                                    <td>{{ $Evaluation->rated_by }}</td>
                                                    <td>{{ $Evaluation->position }}</td>
                                                    <td style="text-align: right;">{{ $Evaluation->rating }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
@stop