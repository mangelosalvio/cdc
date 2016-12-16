@extends('home')
@section('body')
    <style>
        .attendance-table td{
            font-size: .8vw;
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
            <table class="table">
                <thead>
                <tr>
                    <td style="width:1%"></td>
                    <td style="width:1%"></td>
                    <td style="width:10%;">Student No</td>
                    <td>Student Name</td>
                    <td style="width:10%;">Course</td>
                </tr>
                </thead>
                <tbody>
                @foreach($Registration as $i => $Student)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td><span data-id="{{ $Student->id }}" class="glyphicon glyphicon-trash trash" aria-hidden="true"></span></td>
                        <td>{{ $Student->student_no }}</td>
                        <td><input type="text" data-id="{{ $Student->id }}" value="{{ $Student->student_name }}" class="form-control student-name"></td>
                        <td><input type="text" data-id="{{ $Student->id }}" value="{{ $Student->course }}" class="form-control student-course" ></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


    </div>

    <script>
        $('.student-name').keyup(function(event){
            if ( event.which == 13 ) {
                var form_data = {
                    registration_id : $(this).data("id"),
                    _token : $('#token').val(),
                    value : $(this).val(),
                    column : 'student_name'
                };

                $.post('{{ url('/events/register/update') }}', form_data, function(data){
                    alert("Name Updated");
                });

            }
            return false;
        });

        $('.student-course').keyup(function(event){
            if ( event.which == 13 ) {
                var form_data = {
                    registration_id : $(this).data("id"),
                    _token : $('#token').val(),
                    value : $(this).val(),
                    column : 'student_course'
                };

                $.post('{{ url('/events/register/update') }}', form_data, function(data){
                    alert("Course Updated");
                });

            }
            return false;
        });

        $('.trash').click(function(event){

            var form_data = {
                id : $(this).data("id"),
                _token : $('#token').val()
            };


            var e = $(this);


            $.post('{{ url('/events/register/delete') }}', form_data, function(data){
                $(e).parent().parent().remove();
            });


        });
    </script>

@stop