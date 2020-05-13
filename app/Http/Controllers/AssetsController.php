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
     * @return \Illuminate\Http\Response
     */
     public function relocate($serial_number,$asset_type)
     {

       /* Test
       $client = new Client();
       $response = $client->request('GET', 'https://www.yamanisa.com/comj/wp-json/gf/v2/forms/13/entries', ['auth' => [ env('API_KEY'), env('API_PASSWORD')]]);
       $statusCode = $response->getStatusCode();
       $body = $response->getBody()->getContents();
       return $body;
       */

       // Post Assets to Relocation E-form
       $username = Auth::user()->name;
       $client = new Client();
       $response = $client->request('POST', 'https://www.yamanisa.com/comj/wp-json/gf/v2/forms/13/entries',[
         'json'    => ['1' => $username,'2' => $asset_type,'3' => $serial_number],
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
