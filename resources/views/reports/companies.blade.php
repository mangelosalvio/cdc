@extends('report')
@section('body')
    <style>
        .report-table{
            width:100%;
            border-collapse: collapse;
        }
        .report-table td{
            border:1px solid #000;
            padding:1px;
        }
        .report-table td{
            font-size:10px;
        }

        table { page-break-after:auto;}
        tr    { page-break-inside:avoid;}
        td    { page-break-inside:auto;}
        thead { display:table-header-group; }
        tbody { display:table-row-group;}
    </style>


    <table class="report-table">
        <tbody>
        @foreach( $Companies as $Company )
            <tr>
                <td colspan="8" style="font-weight: bold;">{{ $Company->company_name }}</td>
            </tr>
            <tr>
                <td colspan="8">Address:{{ $Company->address }}</td>
            </tr>
            <tr>
                <td colspan="8">Contact Person: {{ $Company->company_contact_person }}</td>
            </tr>
            <tr>
                <td colspan="8">Date/Time Visited:</td>
            </tr>
            @foreach($Company->students()->where('internship_taken_id','=',3)->orderBy('student_name')->get() as  $i => $Student)
                <tr>
                    <td style="padding-left:10px; width:1%;">{{ $i + 1 }}</td>
                    <td style="width:25%;">{{ $Student->student_name }}</td>
                    <td style="width:2%;">{{ $Student->course->course_desc }}</td>

                    <td style="width:5%; font-style: italic;">Accepted</td>
                    <td style="width:3%;"></td>

                    <td style="width:5%; font-style: italic;" nowrap>On-Duty</td>
                    <td style="width:3%;"></td>

                    <td style="font-style: italic;">Remarks:</td>
                </tr>
            @endforeach
        @endforeach
        </tbody>
    </table>
@stop