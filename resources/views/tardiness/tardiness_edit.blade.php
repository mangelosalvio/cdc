@extends('home')
@section('body')
    {!! Form::open([ 'url' => 'tardiness', 'method' => 'GET' ]) !!}
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

    {!! Form::model($Tardiness, array('url' => 'tardiness', 'class' => 'form-horizontal', 'files' => true)) !!}

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {!! Form::hidden('id') !!}

        <div class="form-group form-group-sm">
            {!! Form::label("student_id", "Student Name",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::select("student_id",
                array('' => 'Select Student') +
                $Students,
                null,
                [
                "id" => "student_id",
                "class" => "form-control",
                ]) !!}

            </div>
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("from_date", "From Date",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::text("from_date", null,
                [
                "id" => "from_date",
                "class" => "form-control datepicker"
                ]) !!}
            </div>
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("to_date", "To Date",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::text("to_date", null,
                [
                "id" => "to_date",
                "class" => "form-control datepicker"
                ]) !!}
            </div>
        </div>


        <div class="form-group form-group-sm">
            {!! Form::label("reason", "Reason",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-md-10" >
                {!! Form::text("reason", null,
                [
                "id" => "reason",
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

        <hr>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-5">
                {!! Form::submit('Save', [
                    'class' => 'btn btn-default'
                    ]) !!}
                <a href="{{ url('tardiness/create') }}" class="btn btn-default" >New</a>
            </div>
        </div>

    {!! Form::close() !!}
@stop