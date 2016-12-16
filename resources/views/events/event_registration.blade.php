@extends('home')
@section('body')
    <style>
        .attendance-table td{
            font-size: .8vw;
        }
        table{
            border-collapse: collapse;
            width: 100%;
        }

        table td {
            text-align: left;
            border:1px solid #c0c0c0;
        }
    </style>

    @if ( Session::has('msg') )
    <div class="row alert alert-danger alert-dismissable text-center" role="alert">
        <h3>
            {{ Session::get('msg') }}
        </h3>

    </div>
    @endif

    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">

    <h3>{{ $Event->event_desc }} <br/><small>{{ $Event->event_date->toFormattedDateString() }}</small></h3>

    <div class="row">
        <div class="col-xs-12">
            {!! Form::hidden('event_id',$Event->id,['id' => 'event_id']) !!}
            <div class="form-group">
                <label for="student_no">Student ID</label>
                <input type="text" class="form-control" id="student_no" name="student_no" placeholder="ID No." value="{{ isset($student_no) ? $student_no : ''  }}" @if(!$display_form) autofocus="autofocus" @endif autocomplete="off" />
            </div>
        </div>

        <div class="col-xs-12 text-center">
            <div style="font-size:40px; font-weight: bold; overflow: auto;  max-height: 300px;" id="name"></div>
        </div>
    </div>

    <script>
        $('#student_no').keyup(function(event){
            if ( event.which == 13 ) {

                var form_data = {
                    student_no : $(this).val(),
                    _token : $('#token').val(),
                    event_id : $('#event_id').val()
                };

                $.post('{{ url('/events/register') }}', form_data, function(data){
                    $('#name').html(data);
                });

                $(this).val('');

            }

            return false;
        });
    </script>
@stop