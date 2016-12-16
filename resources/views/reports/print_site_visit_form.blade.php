@extends('reports')
@section('body')
    <script>
        function printPage() { print(); } //Must be present for Iframe printing
    </script>
    <style>
        table{
            border-collapse: collapse;
        }
        table thead{
            font-weight: bold;
        }
        table td{
            padding:2px 3px;
        }

        .heading{
            width: 100%;
            margin-bottom: 20px;
        }
        .heading td:nth-child(odd) {
            white-space: nowrap;
            width: 10%;
            text-align: right;
            padding: 2px 3px;
        }
        .heading td:nth-child(even) {
            border-bottom: 1px solid #000;
            padding: 5px 3px;
            font-weight: bold;
        }
        .body{
            width: 100%;
        }
        .body td:nth-child(odd){
            white-space: nowrap;
        }

        .body td{
            border:1px solid #000;
            border-collapse: collapse;
            padding:5px 2px;
        }
        .footer{
            width:100%;
        }
        .footer td{
            border:1px solid #000;
            padding:5px 2px;
        }
    </style>

    <div style="text-align: center; margin-bottom: 20px;">
        <span style="font-size: 14px; font-weight: bold;" >UNIVERSITY OF ST. LA SALLE <br>CAREER DEVELOPMENT CENTRE</span>
        <br><br>
        <span style="font-size: 12px; font-weight: bold;" >INTERNSHIP SITE VISIT FORM <br>AY 2016-2017</span>
    </div>

    <table class="heading">
        <tbody>
        <tr>
            <td style="width: 10%;">Date</td>
            <td style="width: 40%;" contenteditable="true"><?= \Carbon\Carbon::now()->toFormattedDateString() ?></td>
            <td style="width: 10%;">Contact Person</td>
            <td style="width: 40%;" contenteditable="true">&nbsp;</td>
        </tr>
        <tr>
            <td>Company</td>
            <td contenteditable="true">{{ $Company->company_name }}</td>
            <td>Position</td>
            <td contenteditable="true">&nbsp;</td>
        </tr>
        <tr>
            <td>Address</td>
            <td contenteditable="true" >{{ $Company->address }}</td>
            <td>Department</td>
            <td contenteditable="true">&nbsp;</td>
        </tr>
        <tr>
            <td>Contact No.</td>
            <td contenteditable="true">&nbsp;</td>
            <td>Signature</td>
            <td contenteditable="true">&nbsp;</td>
        </tr>
        </tbody>
    </table>

    <table class="body">
        <thead>
        <tr>
            <td style="width: 1%;">#</td>
            <td style="text-align: center; width: 30%; white-space: nowrap;">STUDENT NAME</td>
            <td style="text-align: center;">REMARKS</td>
        </tr>
        </thead>
        <tbody>
        @foreach($Students as $i => $Student)
            <tr>
                <td>{{ $i+1 }}</td>
                <td style="text-transform: capitalize; white-space: nowrap; text-transform: uppercase;" contenteditable="true">{{ $Student->student_name }}</td>
                <td style="text-align: left;" contenteditable="true"></td>
            </tr>
        @endforeach
        @for( $i = $Students->count() + 1 ; $i <= 20 ; $i++)
            <tr>
                <td >{{ $i }}</td>
                <td style="text-transform: capitalize; white-space: nowrap; text-transform: uppercase;" contenteditable="true">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        @endfor
        </tbody>
    </table>

    <div style="margin: 20px;">
        <table style="width: 100%;">
            <tbody>
            <tr>
                <td style="white-space: nowrap; width: 10%;">Student Course:</td>
                <td style="border-bottom: 1px solid #000; text-align: left;" contenteditable="true">&nbsp;</td>
            </tr>
            </tbody>
        </table>
    </div>

    <table class="footer">
        <tbody>
        <tr>
            <td colspan="2">Purpose</td>
            <td>Notes</td>
        </tr>
        <tr>
            <td style="width:4%;">&nbsp;</td>
            <td style="width: 20%;">Courtesy Visit</td>
            <td rowspan="7"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Reservation</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Endorsement</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Monitoring</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Survey</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>Others: <div style="display:inline-block; width:80%;" contenteditable="true">&nbsp;</div></td>
        </tr>
        </tbody>
    </table>

    <div style="margin:20px;" class="clearfix">
        <div style="display:inline-block; width:40%;">
            Prepared by: <br>
            <div style="margin-top:30px; border-bottom: 1px solid #000; text-align: center; font-weight: bold;" contenteditable="true">

            </div>
            <div style="text-align: center;">
                Internship Coordinator
            </div>

        </div>

        <div style="display:inline-block; width:40%; float: right;">
            Verified by: <br>
            <div style="margin-top:30px; border-bottom: 1px solid #000; text-align: center; font-weight: bold;" contenteditable="true">
                MR. JOHN MICHAEL A. MONTELIBANO
            </div>
            <div style="text-align: center;">
                Head, Internship Program
            </div>
        </div>

        <br>

        <div style="display:inline-block; width:40%;">
            Approved by: <br>
            <div style="margin-top:30px; border-bottom: 1px solid #000; text-align: center; font-weight: bold;" contenteditable="true">
                DR. ANNABELLE C. BALOR
            </div>
            <div style="text-align: center;">
                Asst. Vice-Chancellor for Academic Affairs
            </div>
        </div>

    </div>

    <script>
        $('tbody tr').each(function(i, e){
            if ( $(e).find("td:nth-child(8)").html() == "NO" ) {
                $(e).css('background-color','#F00');
                $(e).css('color','#FFF');
            }

        });
    </script>

@endsection