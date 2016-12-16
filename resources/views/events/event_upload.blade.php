@extends('home')
@section('body')
    {!! Form::open([
        'url' => '/events/uploadFile',
        'files' => true
    ]) !!}

    <div class="form-inline">
        <div class="form-group">
            {!! Form::file('file') !!}

            {!! Form::select('event_id',
            $Events,
            null,
            [ "class" => "form-control"]
            ) !!}

            {!! Form::submit('Upload', [
            'class' => 'btn btn-default'
            ]) !!}
        </div>
    </div>


    {!! Form::close() !!}
@stop