@extends('report')
@section('body')
    <table>
        <tbody>
        @foreach( $Students as $Student )
        <tr>
            <td>
                {{ $Student->student_name }}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

@stop