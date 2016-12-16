@extends('reports')
@section('body')
    <script>
        function printPage() { print(); } //Must be present for Iframe printing
    </script>
    <style>
        table{ border-collapse: collapse; width: 100%; }
        table thead{
            font-weight: bold;
        }
        table td{
            padding:2px 3px;
            border: 1px solid #000;
            vertical-align: top;

        }
        table { page-break-inside:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
    </style>

    <div style="text-align: center;">
        <img src="{{ asset("img/CDC.png") }}" style="width:300px; margin-bottom: -50px;">
    </div>

    <table>
        <thead>
        <tr>
            <th style="width: 1%;">#</th>
            <th>STUDENT NO</th>
            <th>NAME</th>
            <th>COURSE</th>
            <th>LOG</th>
        </tr>
        </thead>
        <tbody>
        @foreach($Registrations as $i => $Registration)
            <tr>
                <td style="width: 1%;">{{ $i+1 }}</td>
                <td style="width:5%;">{{ $Registration->student_no }}</td>
                <td style="width:25%;">{{ $Registration->student_name }}</td>
                <td style="width:5%">{{ $Registration->course }}</td>
                <td>
                    @foreach($Registration->logs as $Log)
                        {{ $Log->log_time }} ( {{ $Log->log_status }} ) <br>
                    @endforeach

                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

@endsection