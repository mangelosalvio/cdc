@extends('reports')
@section('body')
<style >
    *{
        font-size: 10px;
        font-family: "Roboto", Helvetica, Arial, sans-serif;
    }

    table{
        border-collapse: collapse;
        width: 100%;
    }
    table thead td{
        border:1px solid #000;
        font-weight: bold;
    }
    table tbody td{
        border-left: 1px solid #000;
        border-right: 1px solid #000;
    }
    table tbody tr:last-child td{
        border-bottom: 1px solid #000;
    }
    @media print {
        table { page-break-after:auto }
        tr    { page-break-inside:avoid; page-break-after:auto; }
        td    { page-break-inside:avoid; page-break-after:auto }
        thead { display:table-header-group }
        tfoot { display:table-footer-group }
    }

</style>
<div class="col-xs-12">
    <p>
        {{ \Carbon\Carbon::now()->format("F j, Y") }}
        <br><br>
    </p>
    <p>
        Mr. Galo Gessner Rosales <br>
        Discipline Officer <br>
        University of St. La Salle
        <br><br>
    </p>
    <p>
        Dear Sir:
    </p>
    <p>
        Last September 15, 2015, we had an IT/CS Orientation. This orientation is for the 4th Year Information Technology and Computer Science students who
        will be undertaking their Internship/On-the-Job Training this October, 2015.
    </p>
    <p>
        I would like to request your good office, to excuse the following students in their attendance last September 15, 2015.
    </p>
    <table class="table table-bordered attendance-table">
        <thead>
        <tr>
            <td style="width:10%;">Student No</td>
            <td>Name</td>
        </tr>
        </thead>
        <tbody>
        @foreach($Registration as $r)
            <tr>
                <td>{{ $r->student_no }}</td>
                <td>{{ $r->student_name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p>
        Thank you, <br><br><br>
        Michael Angelo O. Salvio, CpE, MIT <br>
        Internship Coordinator <br>
        College of Engineering and Technology <br>
        Unversity of St. La Salle
    </p>
</div>

@stop