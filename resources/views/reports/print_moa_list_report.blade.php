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

    <table>
        <tbody>
        @foreach($Colleges as $College)
            <tr>
                <td colspan="3" style="font-size: 14px; font-weight: bold;">{{ $College->college_desc }}</td>
            </tr>
            @foreach($College->categories as $Category)
                <tr>
                    <td></td>
                    <td colspan="2" style="font-size: 12px; font-weight: bold;">{{ $Category->name }}</td>
                </tr>
                @foreach($Category->companies as $Company)
                    <tr contenteditable="true">
                        <td></td>
                        <td></td>
                        <td>{{ $Company->company_name }}</td>
                    </tr>
                @endforeach
            @endforeach

        @endforeach

        </tbody>
    </table>

@endsection