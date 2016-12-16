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

        }
        table { page-break-inside:auto }
        tr    { page-break-inside:avoid; page-break-after:auto }
    </style>

    <div style="text-align: center;">
        <img src="{{ asset("img/CDC.png") }}" style="width:300px; margin-bottom: -50px;">
    </div>
    <div style="text-align: center;">
        <h1 style="font-size: 18px;">{{ $College->college_desc }} PARTNERS as of {{ \Carbon\Carbon::now()->toDateTimeString() }}</h1>
    </div>

    <table>
        <thead>
        <tr>
            <td>COMPANY</td>
            <td>ADDRESS</td>
            <td>CONTACT PERSON</td>
            <td>POSITION</td>
            <!-- <td>NATURE OF BUSINESS</td> -->
            <td>NATURE OF PARTNERSHIP</td>
        </tr>
        </thead>
        <tbody>
        @foreach($College->companies as $Company)
            <tr>
                <td>{{ $Company->company_name }}</td>
                <td>{{ $Company->address }}</td>
                <td>{{ $Company->company_contact_person }}</td>
                <td>{{ $Company->position }}</td>
                <!-- <td>{{ $Company->nature_of_business }}</td> -->
                <td>ACADEMIC</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection