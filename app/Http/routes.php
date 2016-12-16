<?php

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('/', function () {
    return Redirect::to("/student");
});

Route::get('req','StudentsController@test');
Route::get('student/print/{student_no}','StudentsController@printRequirements');

Route::get('student/cpe','StudentsController@cpe');

Route::get('seminar','StudentsController@seminar');
Route::get('student/{student_id}/delete','StudentsController@delete');
Route::get('student/{student_id}/company/dtr/{dtr_id}/delete','StudentsController@dtrDelete');
Route::post('student/company/requirements','StudentsController@companyRequirements');
Route::post('student/company/dtr','StudentsController@companyDtr');
Route::get('student/{student_id}/company/{company_id}/delete','StudentsController@deleteCompany');

Route::get('student/{student_id}/tpe/{tpe_id}/delete','StudentsController@deleteTpe');

Route::post('student/search','StudentsController@search');
Route::resource('student','StudentsController');


Route::get('company/print','CompanyController@printReport');
Route::post('company/college','CompanyController@updateCollege');
Route::post('company/moa-category','CompanyController@updateMoaCategory');
Route::get('company/{id}/delete','CompanyController@deleteCompany');

Route::resource('company','CompanyController');


Route::resource('requirement','RequirementController');

Route::get('events/attendees','EventController@attendees');
Route::get('events/{id}/registration','EventController@registration');
Route::get('events/{id}/registration/list','EventController@listing');
Route::get('events/{id}/registration/display','EventController@registrationDisplay');

Route::post('events/register','EventController@register');
Route::post('events/register/update','EventController@updateRegistration');
Route::post('events/register/delete','EventController@deleteRegistration');

Route::get('events/upload','EventController@upload');
Route::get('events/update','EventController@update');
Route::post('events/registration','EventController@eventRegistration');
Route::post('events/registration/import','EventController@import');
Route::post('events/registration/export','EventController@export');

Route::post('events/uploadFile','EventController@uploadFile');
Route::post('events/uploadAttendees','EventController@uploadAttendees');
Route::resource('events','EventController');


Route::resource('tpe','EvaluationController');
Route::post('tpe/tpe-category', 'EvaluationController@insertTPECategory');
Route::post('tpe/tpe-question', 'EvaluationController@insertTPEQuestion');
Route::get('student/tpe/{student_id}/{company_id}/{version}', 'StudentsController@getTPE');
Route::post('student/tpe/{student_id}/{company_id}/{version}', 'StudentsController@storeTPE');


Route::get('/cs','StudentsController@cs');


Route::get('/uploads/class-record','UploadController@classRecord');
Route::post('/uploads/class-record','UploadController@uploadClassRecord');

/**
 * Reports
 */

/**
 * STUDENT INTERNS REPORT
 */
Route::get('reports/student-interns','ReportController@studentInterns');
Route::post('reports/student-interns','ReportController@searchStudentInterns');
Route::get('reports/print-student-interns/{course_id}/{internship_taken_id?}/{internship_enrolled_id?}/{company_id?}','ReportController@printStudentInterns');

/**
 * COMPANY LIST REPORT
 */
Route::get('reports/company-list','ReportController@companyListing');
Route::post('reports/company-list','ReportController@searchCompanyListing');
Route::get('reports/print-company-list','ReportController@printCompanyListing');

Route::get('merge','ReportController@merge');


/**
 * SITE VISIT FORM
 */
Route::get('reports/site-visit-form','ReportController@siteVisitForm');
Route::post('reports/site-visit-form','ReportController@searchSiteVisitForm');
Route::get('reports/print-site-visit-form','ReportController@printSiteVisitForm');

Route::resource('tardiness','TardinessController');

/**
 * COMPANY LIST REPORT
 */

Route::get('reports/moa-list','ReportController@moaListing');
Route::post('reports/moa-list','ReportController@searchMoaListing');
Route::get('reports/print-moa-list','ReportController@printMoaListing');

/**
 * EVENT ATTENDANCE
 */

Route::get('reports/event-attendance','ReportController@eventAttendance');
Route::post('reports/event-attendance','ReportController@searchEventAttendance');
Route::get('reports/print-event-attendance','ReportController@printEventAttendance');