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
            border-top:1px solid #000;
            border-bottom: 1px solid #000;
        }
    </style>
    <h4>{{ $Course->course_desc }} as of {{ \Carbon\Carbon::now()->toDateTimeString() }}</h4>
    <table>
        <thead>
        <tr>
            <td>#</td>
            <td>STUDENT NO</td>
            <td>STUDENT NAME</td>
            {{--<td style="text-align: center;">SECTION</td>
            <td>CONTACT NO</td>
            <td>Company</td>
            <td style="text-align: right;">TOTAL HRS</td>
            <td style="text-align: center;">REQS COMPLETED</td>--}}
            <td style="text-align: center;">FINAL GRADE</td>
            <td style="text-align: center;">EQ GRADE</td>
        </tr>
        </thead>
        <tbody>
        @foreach($Students as $i => $Student)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $Student->student_no }}</td>
                {{--<td><input type="text" onclick="this.select();" value="{{ $Student->student_name }}"></td>
                <td><input type="text" onclick="this.select();" value="{{ $Student->contact_no }}"></td>--}}
                <td style="text-transform: capitalize; white-space: nowrap;">{{ strtoupper($Student->student_name) }}</td>
                {{--    <td style=" text-align: center; text-transform: capitalize; white-space: nowrap;">{{ $Student->section }}</td>
                <td>{{ $Student->contact_no }}</td>
                <td>
                    @foreach($Student->companies as $i => $Company)
                        @if($i < $Student->companies()->count())
                            {{ $Company->company_name }}
                        @endif
                    @endforeach
                </td>

                <td style="text-align:right;">{{ $Student->total_hours }}</td>
                <td style="text-align: center;">{!! $Student->completed !!}</td>--}}
                @if( isset( $Student->grade ) )
                    <td style="text-align: center;">{!! $Student->grade->final_grade !!}</td>
                @else
                    <td style="text-align: center;">{!! $Student->final_grade !!}</td>
                @endif
                <td style="text-align: center;">{!! $Student->eq_grade !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <script>
        $('tbody tr').each(function(i, e){
            if ( $(e).find("td:nth-child(8)").html() == "NO" ) {
                $(e).css('background-color','#F00');
                $(e).css('color','#FFF');
            }

        });
    </script>

@endsection