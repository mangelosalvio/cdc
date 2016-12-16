@if ( !empty($Student) )
{{ $Student->student_no }}
{{ $Student->student_name }}

@if( $Student->companies()->count() > 0 )
@foreach($Student->companies as $Company)
{!!  $Company->company_name !!}
@foreach($Requirements as $Requirement)
@if( $Company->pivot->requirements()->find($Requirement->id) != null )
_X_ {!! $Requirement->requirement_desc !!}
@else
___ {!! $Requirement->requirement_desc !!}
@endif
@endforeach

@endforeach
@endif
@endif
