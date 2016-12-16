@extends('home')
@section('body')
    {!! Form::open([
        'url' => 'student/tpe/'. $Student->id .'/'. $Company->id . '/' . $version
    ]) !!}
    <div class="row form-horizontal">
        <div class="form-group">
            {!! Form::label("student_name", "Student Name",
            [
            "class" => "control-label col-sm-2"
            ]) !!}
            <div class="col-xs-10">
                <span class="form-control">{{ $Student->student_name }}</span>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label("company", "Company Name",
            [
            "class" => "control-label col-sm-2"
            ]) !!}
            <div class="col-xs-10">
                <span class="form-control">{{ $Company->company_name }}</span>
            </div>
        </div>


        <div class="form-group">
            {!! Form::label("rated_by", "Rated by",
            [
            "class" => "control-label col-xs-2"
            ]) !!}
            <div class="col-xs-10">
                {!! Form::text('rated_by', null, [ 'class' => 'form-control' ]) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label("position", "Position",
            [
            "class" => "control-label col-xs-2"
            ]) !!}
            <div class="col-xs-10">
                {!! Form::text('position', null, [ 'class' => 'form-control' ]) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label("date", "Date Rated",
            [
            "class" => "control-label col-xs-2"
            ]) !!}
            <div class="col-xs-10">
                {!! Form::text('date', null, [ 'class' => 'form-control datepicker' ]) !!}
            </div>
        </div>
        {!! Form::hidden('tpe_version', 'v' . $version) !!}

        @if($version == 2)
            <div class="col-xs-offset-8 col-xs-1">1</div>
            <div class="col-xs-1">2</div>
            <div class="col-xs-1">3</div>
            <div class="col-xs-1">4</div>

            @foreach($TpeCategories as $j => $TpeCategory)
                <div class="col-xs-8">
                    <span style="font-weight: bold;">{{ $TpeCategory->tpe_category }}</span>
                    ({{ $TpeCategory->tpe_rate }}%)
                    <input type="hidden" name="arr_category_id[]" value="{{ $TpeCategory->id }}">
                </div>
                @foreach($TpeCategory->questions as $i => $Question)
                    <div class="col-xs-offset-1 col-xs-7">{{ $i + 1 }}. {{ $Question->tpe_question }}</div>
                    <div class="col-xs-1">
                        <input type="radio" name="arr_answer[{{ $j }}][{{ $i }}]"
                                value="1" >
                    </div>
                    <div class="col-xs-1">
                        <input type="radio" name="arr_answer[{{ $j }}][{{ $i }}]"
                                value="2">
                    </div>
                    <div class="col-xs-1">
                        <input type="radio" name="arr_answer[{{ $j }}][{{ $i }}]"
                                value="3">
                    </div>
                    <div class="col-xs-1">
                        <input type="radio" name="arr_answer[{{ $j }}][{{ $i }}]"
                                value="4">
                        <input type="hidden" name="arr_question_id[]" value="{{ $Question->id }}">
                    </div>
                @endforeach
            @endforeach
        @elseif( $version == 1 )
            <table class="table">
                <thead>
                <tr>
                    <td></td>
                    @for($i = 10 ; $i >= 1 ; $i--)
                        <td>{{ $i }}</td>
                    @endfor
                </tr>
                </thead>
                <tbody>
                @foreach($TpeQuestions as $j => $Question)
                    <tr>
                        <td>
                            {{ $Question->tpe_question }}
                            <input type="hidden" name="arr_category_id[]" value="{{ $Question->tpe_category_id }}">
                            <input type="hidden" name="arr_question_id[]" value="{{ $Question->id }}">
                        </td>
                        @for($i = 10 ; $i >= 1 ; $i--)
                            <td>
                                <input type="radio" name="arr_answer[{{ $j }}]"
                                       value="{{ $i }}">
                            </td>
                        @endfor
                    </tr>
                @endforeach
                </tbody>
            </table>


        @endif
    </div>
    <div class="row">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
    {!! Form::close() !!}
@endsection