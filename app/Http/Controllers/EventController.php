<?php

namespace App\Http\Controllers;

use App\Attendees;
use App\Event;
use App\Preregistration;
use App\Registration;
use App\RegistrationLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class EventController extends Controller
{

    public function __construct(){
        $Events = Event::get()->lists('event_desc','id')->all();

        $arr_colleges = [
            '',
            'College of Arts and Sciences',
            'College of Business and Accountancy',
            'Colle of Engineering and Technology'
        ];

        $arr_courses = [
            '',
            'Information Technology',
            'Computer Science',
            'Computer Engineering',
            'Chemical Engineering',
            'Food and Technology',
            'Electrical Engineering',
            'Electronics Engineering',
            'Materials Engineering',
            'Hospitality Management',
            'Toursim Management',
            'Mass Communications',
            'IDS',
            'Political Science',
            'Agribusiness',
            'Business Economics',
            'Management Accounting',
            'Marketing Management',
            'Operations Management',
            'BS Psychology',
            'AB Psychology',
            'BS Bio'
        ];
        return view()->share(compact(['Events','arr_colleges','arr_courses']));

    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }


    public function update()
    {
        Registration::whereEventId(1)
            ->orderBy('id','desc')
            ->get()->each(function($Reg){
                if ( $Reg->created_at->hour == 16 ) {
                    $Reg->time_in = $Reg->created_at->copy()->addHours(16);
                } else if ( $Reg->created_at->hour == 1 || $Reg->created_at->hour == 0 ){
                    $Reg->time_in = $Reg->created_at->copy()->addHours(8);
                } else {
                    $Reg->time_in = $Reg->created_at;
                }
                $Reg->save();

            });

    }

    public function listing($id){
        $Event = Event::findOrNew($id);
        $Registration = Registration::whereEventId($id)->orderBy('id','desc')->get();


        return view('events.event_listing',compact(['Registration','Event']));
    }

    public function register(Request $request)
    {
        $Student = Attendees::whereStudentNo(trim($request->input('student_no')))->first();

        $Registration = Registration::whereStudentNo($request->input('student_no'))
            ->whereEventId($request->input('event_id'))
            ->orderBy('id','desc')
            ->first();


        if ( $Registration != null ) {
            $log_status = $Registration->logs()->orderBy('id','desc')->first()->log_status;
            if ( $log_status == "IN"  ) {
                $log_status = "OUT";
            } else {
                $log_status = "IN";
            }


            $Log = new RegistrationLogs([
                'log_time' => Carbon::now(),
                'log_status' => $log_status
            ]);

            $Registration->logs()->save($Log);

            if ( $Student == null  ){
                $name = $request->input('student_no');
            } else {
                $name = $Student->student_name;
            }

            $content = "
                $name  <br>
                <table>
                    <tbody>";

            foreach ( $Registration->logs()->orderBy('id','desc')->get() as $Log ) {
                $content .= "
                    <tr>
                        <td>{$Log->log_status}</td>
                        <td>{$Log->log_time}</td>
                    </tr>
                ";
            }

            $content .= "
                    </tbody>
                </table>


            ";


            return $content;
        } else {
            if ( $Student != null ) {
                $Registration = Registration::create([
                    'student_no' => $Student->student_no,
                    'student_name' => $Student->student_name,
                    'course' => $Student->course,
                    'event_id' => $request->input('event_id')
                ]);

                /**
                 * first registration w/ name
                 */

                $Log = new RegistrationLogs([
                    'log_time' => Carbon::now(),
                    'log_status' => 'IN'
                ]);

                $Registration->logs()->save($Log);

                $content = "
                 {$Student->student_name} registered <br>
                <table>
                    <tbody>";

                foreach ( $Registration->logs()->orderBy('id','desc')->get() as $Log ) {
                    $content .= "
                    <tr>
                        <td>{$Log->log_status}</td>
                        <td>{$Log->log_time}</td>
                    </tr>
                ";
                }

                $content .= "
                    </tbody>
                </table>


            ";

                return $content;

            } else {

                $Registration = Registration::create([
                    'student_no' => trim($request->input('student_no')),
                    'event_id' => $request->input('event_id')
                ]);


                /**
                 * first registration with no name
                 */

                $Log = new RegistrationLogs([
                    'log_time' => Carbon::now(),
                    'log_status' => 'IN'
                ]);

                $Registration->logs()->save($Log);

                $content = "
                 {$request->input('student_no')} <br>
                <table>
                    <tbody>";

                foreach ( $Registration->logs()->orderBy('id','desc')->get() as $Log ) {
                    $content .= "
                    <tr>
                        <td>{$Log->log_status}</td>
                        <td>{$Log->log_time}</td>
                    </tr>
                ";
                }

                $content .= "
                    </tbody>
                </table>


            ";

                return $content;
            }


        }
    }

    public function updateRegistration(Request $request){

        $Registration = Registration::find($request->input('registration_id'));
        if ( $request->input('column') == "student_course" ) {
            $Registration->course = $request->input('value');
        } else {
            $Registration->student_name = $request->input('value');
        }
        $Registration->save();

    }

    public function deleteRegistration(Request $request){
        $Registration = Registration::find($request->input('id'));
        $Registration->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload(){
        return view('events.event_upload', compact([]));
    }

    public function attendees(){
        $Attendees = Attendees::all();

        return view('events.attendees', compact([
            'Attendees'
        ]));
    }

    public function uploadFile(Request $request){
        if ( $request->hasFile('file') && $request->has('event_id') ) {
            $event_id = $request->input('event_id');
            $File = $request->file('file');
            Excel::load($File, function ($reader) use ($event_id) {
                $reader->each(function($sheet) use ($event_id) {
                    $data = $sheet->toArray();

                    /**
                     * look for student, if found, do not register again
                     */
                    $data['student_no'] = str_pad((int)$data['id_number'],7,0,STR_PAD_LEFT);
                    $data['contact_no'] = str_pad((int)$data['contact_no'],11,0,STR_PAD_LEFT);

                    $Preregistration = Preregistration::whereStudentNo($data['student_no'])
                        ->whereEventId($event_id)->first();

                    if ( $Preregistration == null ) {
                        Preregistration::create([
                            'event_id' => $event_id,
                            'student_name' => $data['name'],
                            'student_no' => $data['student_no'],
                            'course' => $data['course'],
                            'email' => $data['email_address'],
                            'contact_no' => $data['contact_no'],
                            'college' => $data['college']
                        ]);
                    } else {
                        $Preregistration->update([
                            'event_id' => $event_id,
                            'student_name' => $data['name'],
                            'student_no' => $data['student_no'],
                            'course' => $data['course'],
                            'email' => $data['email_address'],
                            'contact_no' => $data['contact_no'],
                            'college' => $data['college']
                        ]);
                    }
                });
            });
        }

        return view('events.event_upload', compact([]));
    }

    public function uploadAttendees(Request $request){
        if ( $request->hasFile('file') ) {
            $File = $request->file('file');
            Excel::load($File, function ($reader) {
                $reader->each(function($sheet)  {
                    $data = $sheet->toArray();

                    //dd($data);

                    /**
                     * look for student, if found, do not register again
                     */

                    if ( count($data) ) {
                        foreach ( $data as $Student ){
                            $Student['student_no'] = trim(str_pad(trim($Student['id']),7,0,STR_PAD_LEFT));
                            $Student['student_no'] = preg_replace("/[^0-9,.]/", "", $Student['student_no'] );

                            //dd($Student['student_no']);

                            $Attendees = Attendees::whereStudentNo($Student['student_no'])
                                ->first();

                            if ( $Attendees == null ) {

                                Attendees::create([
                                    'student_name' => $Student['name'],
                                    'student_no' => $Student['student_no'],
                                    'course' => $Student['course']
                                ]);
                            }
                        }
                    }

                });
            });
        }

        return redirect("events/attendees");
    }

    public function import(Request $request){
        if ( $request->hasFile('file') ) {
            $arr = json_decode(File::get($request->file('file')->getRealPath()));

            if ( count( $arr ) ) {
                foreach ( $arr as $r ) {
                    $Reg = Registration::whereStudentNo($r->student_no)
                        ->whereEventId($r->event_id)
                        ->first();

                    if ( $Reg == null ) {
                        Registration::create([
                            'student_no' => $r->student_no,
                            'student_name' => $r->student_name,
                            'event_id' => $r->event_id,
                            'course' => $r->course,
                            'email' => $r->email,
                            'contact_no' => $r->contact_no,
                            'time_in' => $r->time_in,
                            'college' => $r->college
                        ]);
                    }

                    set_time_limit(30);
                }
            }
        }

        return Redirect::to("/events/" . $request->input('event_id') . '/registration' );
    }

    public function registration($id){
        $Event = Event::find($id);
        $display_form = false;
        $student_no = "";

        $Registration = Registration::whereEventId($id)
            ->orderBy('id','desc')
            ->get();

        return view('events.event_registration',compact(['Event', 'display_form','student_no','Registration']));
    }

    public function eventRegistration(Request $request){
        $Event = Event::find($request->input('event_id'));

        $Pregistration = Preregistration::whereStudentNo($request->input('student_no'))
            ->whereEventId($request->input('event_id'))->first();

        if ( $Pregistration ) {
            /*has preregistration*/
            $display_form = false;

            $Reg = Registration::whereStudentNo($request->input('student_no'))
                ->whereEventId($request->input('event_id'))
                ->first();

            /**
             * if has not registered
             */

            $msg = null;

            if ( $Reg == null ) {

                $data = $Pregistration->toArray();
                $data['time_in'] = Carbon::now()->toDateTimeString();
                Registration::create($data);
            } else {
                $msg = "$Reg->student_name has already registered";
            }

            return Redirect::to("/events/" . $request->input('event_id') . '/registration' )->with(compact(['msg']));

        } else {

            /**
             * do not allow students without registration
             */
            /*$msg = "Student No. ". $request->input('student_no') . ' did not preregister';
            return Redirect::to("/events/" . $request->input('event_id') . '/registration' )->with('msg', $msg);*/

            /*not registred*/
            $display_form = true;
            $student_no = $request->input('student_no');

            if ( $request->has('student_name') ) {
                /**
                 * check if already registred
                 */

                $Reg = Registration::whereStudentNo($request->input('student_no'))
                    ->whereEventId($request->input('event_id'))
                    ->first();

                if ( $Reg == null ) {
                    $R = Registration::create([
                        'event_id' => $request->input('event_id'),
                        'student_name' => $request->input('student_name'),
                        'student_no' => $request->input('student_no'),
                        'email' => $request->input('email'),
                        'contact_no' => $request->input('contact_no'),
                        'college' => $request->input('college'),
                        'course' => $request->input('course'),
                        'time_in' => Carbon::now()
                    ]);
                }



                return Redirect::to("/events/" . $request->input('event_id') . '/registration' );
            } else {

                $Registration = Registration::whereEventId($Event->id)
                    ->orderBy('id','desc')
                    ->get();

                return view('events.event_registration',compact(['Event', 'display_form','student_no','Registration']));
            }

        }
    }


    public function export(Request $request){
        $filename = 'event' . $request->input('event_id') . '.json';
        $Registration = Registration::whereEventId($request->input('event_id'))->get();

        $bytes_written = File::put($filename, $Registration->toJson());
        if ($bytes_written === false)
        {
            dd("Error writing to file");
        }

        return Response::download($filename);
    }
}
