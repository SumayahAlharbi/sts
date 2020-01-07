<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PdfReport;
use CSVReport;
use Carbon\Carbon;

use App\Ticket;
use App\User;
use App\Location;

class ReportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $agentUsers = User::whereHas('roles', function ($query) {
        $query->where('name', '=', 'agent');
        })->get();

        return view('report.index', compact('agentUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



public function displayReport(Request $request)
{
    //app('debugbar')->disable();
    $fromDate = Carbon::parse($request->input('from_date'))->startOfDay();
    $toDate = Carbon::parse($request->input('to_date'))->endOfDay();
    $sortBy = $request->input('sort_by');
    $agentId = $request->input('user_id');

    // $users = User::with(['roles' => function($q){
    // $q->where('name', 'admin');
    // }])->get();

    // $dt = Carbon::now();

    $filename = 'sts_reports_'.Carbon::now()->format('dmy_his');


    $title = 'Registered User Report'; // Report title

    $meta = [ // For displaying filters description on header
        'Tickets from' => $fromDate . ' To ' . $toDate,
        //'Sort By' => $sortBy
    ];

      $queryBuilder = Ticket::select(['id', 'ticket_title', 'created_at', 'location_id', 'created_at', 'status_id', 'category_id']) // Do some querying..
                          ->whereBetween('created_at', [$fromDate, $toDate])
                          ->where('status_id','=',1)
                          ->with(['user' => function ($query) {
                            $query->where('id', '=', $agentId);
                        }])->with(['rating' => function ($query) {
                            $query->select('rating_value');
                        }])->orderBy('id');


    $columns = [ // Set Column to be displayed
        'ID' => 'id',
        'Title' => 'ticket_title',
        'Agent' => function($queryBuilder) {
            $date = array();
            foreach ($queryBuilder->user as $Builder) {
                $date[] = $Builder->name;
            }
            // return json_encode($date);
            return implode(', ', $date);
          },
        'Status' => function($queryBuilder) {
            return $queryBuilder->status->status_name;
          },
          'Rating' => function($queryBuilder) {
            return $queryBuilder->rating->rating_value;
          }
    ];

    CSVReport::of($title, $meta, $queryBuilder, $columns)
             // ->withoutManipulation()
             ->showNumColumn(false)
             ->download($filename);
           }
}
