@extends('home')
@section('body')
    <table class="table">
        <tbody>
        @foreach($Students as $Student)
            <tr>
                <td>{{ $Student->student_name }}</td>
                <td>{{ $Student->contact_no }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>


@stop
