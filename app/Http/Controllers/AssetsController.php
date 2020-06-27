<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use GuzzleHttp\Client;

class AssetsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

     /**
      * Post Assets to Relocation E-form
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  \App\users  $users
      * @return \Illuminate\Http\Response
      */
     public function relocate(Request $request)
     {

       $this->validate($request, [
        'email' => 'required|max:191|string|email',
        'user_name' => 'required|max:191|string',
        'jop_title' => 'required|max:191|string',
        'date' => 'required|date',
        'tel_no' => 'required|numeric',
        'room_no' => 'required|numeric',
        'badge_no' => 'required|numeric',
        'college' => 'required',
        'head_of_department_name' => 'required|max:191|string',
        'head_of_department_email' => 'required|max:191|string|email',
        'asset_type' => 'required',
        'tag_no' => 'required',
        'serial_no' => 'required',
        'current_room' => 'required|numeric',
        'new_room' => 'required|numeric',
        'new_floor' => 'required',
        'new_building' => 'required',
        'current_department1' => 'required',
        'new_department1' => 'required',
        'justification' => 'required'
        ]);

        $user_name = $request->user_name;
        $jop_title = $request->jop_title;
        $email = $request->email;
        $date = $request->date;
        $tel_no = $request->tel_no;
        $room_no = $request->room_no;
        $badge_no = $request->badge_no;
        $college = $request->college;
        $head_of_department_name = $request->head_of_department_name;
        $head_of_department_email = $request->head_of_department_email;
        $asset_type = $request->asset_type;
        $tag_no = $request->tag_no;
        $serial_no = $request->serial_no;
        $current_room = $request->current_room;
        $new_room = $request->new_room;
        $new_floor = $request->new_floor;
        $new_building = $request->new_building;
        $current_department1 = $request->current_department1;
        $current_department2 = $request->current_department2;
        $new_department1 = $request->new_department1;
        $new_department2 = $request->new_department2;
        $justification = $request->justification;

       /* Test
       $client = new Client();
       $response = $client->request('GET', 'https://www.yamanisa.com/comj/wp-json/gf/v2/forms/13/entries', ['auth' => [ env('API_KEY'), env('API_PASSWORD')]]);
       $statusCode = $response->getStatusCode();
       $body = $response->getBody()->getContents();
       return $body;
       */

       // Post Assets to Relocation E-form
       $client = new Client();
       $response = $client->request('POST', 'https://www.yamanisa.com/comj/wp-json/gf/v2/forms/14/entries',[
         'json'    => [
           '2' => $user_name,'3' => $jop_title,'5' => $tel_no,
           '6' => $room_no,'7' => $badge_no,'8' => $date,
           '9' => $head_of_department_name,'10' => $head_of_department_email,'12' => $asset_type,
           '13' => $tag_no,'14' => $serial_no,'15' => $current_room,
           '16' => $new_room, '29' => $new_floor, '30' => $new_building,
           '19' => $justification,'21' => $email,
           '22' => $current_department1,'24' => $current_department2,'23' => $new_department1,
           '25' => $new_department2
       ],
         'auth' => [env('API_KEY'), env('API_PASSWORD')]
       ]);

       $statusCode = $response->getStatusCode();

       $statusCode = 201;
       if ($statusCode =='201'){
         return back()->with('success', 'Assets relocation e-form submitted');
       }
       else{
         return back()->with('danger', 'something went wrong, please try again');
       }
     }
}
