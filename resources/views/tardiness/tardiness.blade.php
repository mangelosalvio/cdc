@extends('home')
@section('body')
    <style>
        table tbody ul{
            list-style: none;
        }
        table tbody ul li{

        }
    </style>
    {!! Form::open([ 'url' => 'tardiness', 'method' => 'GET' ]) !!}
        <div class="form-group row">
            <div class="col-sm-offset-8 col-sm-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="keyword" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" name="submit_btn" value="search">Go!</button>
                        <a href="{!! url('tardiness/create') !!}"><input type="button" class="btn btn-default" value="New"></a>
                    </span>

                </div><!-- /input-group -->

            </div>



        </div>

        <div class="panel">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>STUDENT</th>
                    <th>DATE FILED</th>
                    <th>DATE OF INCLUSIVITY</th>
                    <th>REASON</th>
                    <th>REMARKS</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $Tardiness as $Tardiness )
                    <tr onclick="window.location.href='{{ url("tardiness/$Tardiness->id/edit") }}'">
                        <td>{{ $Tardiness->student->student_name }}</td>
                        <td>{{ $Tardiness->date_filed }}</td>
                        <td>{{ $Tardiness->from_date }} - {{ $Tardiness->to_date }}</td>
                        <td>{{ $Tardiness->reason }}</td>
                        <td>{{ $Tardiness->remarks }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    {!! Form::close() !!}

@stop
