@extends('home')
@section('body')
    {!! Input::old('course_id') !!}
    <div class="row">
        {!! Form::open([
            'url' => 'reports/moa-list',
             'class' => ''
        ]) !!}

        <div class="form-group">
            {!! Form::label('college_id','College') !!}
            {!! Form::select('college_id',
                [ '' => 'All Colleges:' ]
                +
                $Colleges,
                isset( $college_id ) ? $college_id : null,
                [ "class" => "form-control"]
                ) !!}
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
        <iframe id="JOframe" src="{!! url($url) !!}" frameborder="0" style="width:100%; height:400px;"></iframe>
    </div>
    @endif
@endsection