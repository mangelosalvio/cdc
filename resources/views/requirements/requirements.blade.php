@extends('home')
@section('body')
    {!! Form::model($Requirement, array('url'=>'requirement','class' =>'form-horizontal')) !!}
    <div class="form-group form-group-sm">
        {!! Form::label("requirement_desc", "Description",
        [
        "class" => "control-label col-sm-2"
        ]) !!}

        <div class="col-sm-10">
            {!! Form::text("requirement_desc", null,
            [
            "id" => "requirement_desc",
            "class" => "form-control",
            'autofocus' => 'true'
            ]) !!}
        </div>
    </div>

    <div class="form-group form-group-sm">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Save</button>
        </div>
    </div>

    {!! Form::close() !!}

    <div class="panel panel-primary">
        <div class="panel-heading">Requirements</div>
        <table class="table">
            <thead>
            <tr>
                <td>Description</td>
            </tr>
            </thead>
            <tbody>
            @foreach($Requirements as $Req)
                <tr>
                    <td>{{ $Req->requirement_desc }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>


@stop
