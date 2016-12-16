@extends('home')
@section('body')
    <div class="panel panel-primary">
        <div class="panel-heading">
            TPE Category
        </div>
        <div class="panel-body">
            {!! Form::open(array('url'=>'tpe/tpe-category','class' =>'form-horizontal')) !!}
                <div class="form-group form-group-sm">
                    {!! Form::label("tpe_category", "TPE Category",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-sm-10">
                        {!! Form::text("tpe_category", null,
                        [
                        "id" => "tpe_category",
                        "class" => "form-control"
                        ]) !!}
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    {!! Form::label("tpe_rate", "TPE Rate",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-sm-10">
                        {!! Form::text("tpe_rate", null,
                        [
                        "id" => "tpe_rate",
                        "class" => "form-control"
                        ]) !!}
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Save</button>
                    </div>
                </div>

                <table class="table">
                    <thead>
                    <tr>
                        <td>TPE CATEGORY</td>
                        <td>QUESTION</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($TpeCategories as $TpeCategory)
                        <tr>
                            <td>
                                <input type="hidden" name="arr_id[]" value="{{ $TpeCategory->id }}" >
                                <input type="text" name="arr_tpe_category[]" class="form-control" value="{{ $TpeCategory->tpe_category }}">
                            </td>
                            <td><input type="text" name="arr_tpe_rate[]" class="form-control" value="{{ $TpeCategory->tpe_rate }}"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            TPE Questions
        </div>
        <div class="panel-body">
            {!! Form::open(array('url'=>'tpe/tpe-question','class' =>'form-horizontal')) !!}

                <div class="form-group form-group-sm">
                    {!! Form::label("question_version", "Version",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-sm-10">
                        {!! Form::select("question_version",
                        [
                            '' => 'Select Version:',
                            'v1' => 'Version 1',
                            'v2' => 'Version 2'
                        ],
                        old('question_version'),
                        [
                        "id" => "question_version",
                        "class" => "form-control"
                        ]) !!}
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    {!! Form::label("tpe_category_id", "TPE Category",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-sm-10">
                        {!! Form::select("tpe_category_id",
                        [ '' => 'Select Category:' ] +
                        $TpeCategoriesList,
                        old('tpe_category_id'),
                        [
                        "id" => "tpe_category_id",
                        "class" => "form-control"
                        ]) !!}
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    {!! Form::label("tpe_question", "Question",
                    [
                    "class" => "control-label col-sm-2"
                    ]) !!}

                    <div class="col-sm-10">
                        {!! Form::text("tpe_question", null,
                        [
                        "id" => "tpe_question",
                        "class" => "form-control",
                        'autofocus' => 'true'
                        ]) !!}
                    </div>
                </div>

                <div class="form-group form-group-sm">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Save</button>
                        <a href="{{ url('company/print') }}" class="btn btn-default" target="_blank">Print</a>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">Version 1</div>
                    <table class="table">
                        <thead>
                        <tr>
                            <td>TPE CATEGORY</td>
                            <td>TPE QUESTION</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\Evaluation::version(1)->get() as $TpeQuestion)
                            <tr>
                                <td>
                                    <input type="hidden" name="arr_id[]" value="{{ $TpeQuestion->id }}" >
                                    {{ $TpeQuestion->category->tpe_category }}
                                </td>
                                <td>{{ $TpeQuestion->tpe_question }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">Version 2</div>
                    <table class="table">
                        <thead>
                        <tr>
                            <td>TPE CATEGORY</td>
                            <td>TPE QUESTION</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\Evaluation::version(2)->get() as $TpeQuestion)
                            <tr>
                                <td>
                                    <input type="hidden" name="arr_id[]" value="{{ $TpeQuestion->id }}" >
                                    {{ $TpeQuestion->category->tpe_category }}
                                </td>
                                <td>{{ $TpeQuestion->tpe_question }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


            {!! Form::close() !!}
        </div>
    </div>

@stop
