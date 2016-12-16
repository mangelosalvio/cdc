<li><a href="{{ url('student') }}">Students</a></li>
<li><a href="{{ url('tardiness/create') }}">Tardiness</a></li>
<li><a href="{{ url('company') }}">Companies</a></li>
<li><a href="{{ url('requirement') }}">Requirements</a></li>
<li><a href="{{ url('tpe') }}">TPE</a></li>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Events</b><span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li><a href="{{ url('events/7/registration') }}">Events</a></li>
        <li><a href="{{ url('events/attendees') }}">Event Attendees Upload</a></li>
        <li role="separator" class="divider"></li>
    </ul>
</li>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Uploads</b><span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li><a href="{{ url('uploads/class-record') }}">Class Records</a></li>
        <li role="separator" class="divider"></li>
    </ul>
</li>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports</b><span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li><a href="{{ url('reports/student-interns') }}">Student Interns</a></li>
        <li><a href="{{ url('reports/site-visit-form') }}">Site Visit Form</a></li>
        <li><a href="{{ url('events/5/registration/list') }}">1/30/16 Exit Seminar Attendance</a></li>
        <li><a href="{{ url('events/7/registration/list') }}">9/24/16 Exit Seminar Attendance</a></li>
        <li><a href="{{ url('reports/company-list') }}">Company Listing Report</a></li>
        <li><a href="{{ url('reports/moa-list') }}">MOA Listing Report</a></li>
        <li><a href="{{ url('reports/event-attendance') }}">Event Attendance</a></li>
        <li role="separator" class="divider"></li>
    </ul>
</li>