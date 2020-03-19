<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PdfReport;
use CSVReport;
use Carbon\Carbon;
use App\Group;
use App\Ticket;
use App\User;
use App\Location;
use Auth;

class ReportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Auth::user()->group;
        $agentUsers = User::whereHas('group', function($query) use($groups){
            $query->whereIn('group_id', $groups);
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
    $agentId = $request->input('user_id');

    // $users = User::with(['roles' => function($q){
    // $q->where('name', 'admin');
    // }])->get();

    // $dt = Carbon::now();

    $filename = 'sts_reports_'.Carbon::now()->format('dmy_his');


    $title = 'Registered User Report'; // Report title

    $meta = [ // For displaying filters description on header
        'Tickets from' => $fromDate . ' To ' . $toDate,
        'user_id' => $agentId
    ];

      $queryBuilder = Ticket::select(['id', 'ticket_title', 'created_at', 'location_id', 'created_at', 'status_id', 'category_id','requested_by']) // Do some querying..
                          ->whereBetween('created_at', [$fromDate, $toDate])
                          ->where('status_id','=',1)
                          ->with(['user' => function ($query) {
                            $query->where('id', '=', $agentId);
                        }])->with(['rating' => function ($query) {
                            $query->select('rating_value');
                        }])->with(['requested_by_user' => function ($query) {
                            $query->where('id', '=', 'requested_by');
                        }])
                        ->orderBy('id');


    $columns = [ // Set Column to be displayed
        'ID' => 'id',
        'Title' => 'ticket_title',
        'requested_by' => function($queryBuilder) {
            return $queryBuilder->requested_by_user['name'];
          },
        'created_at' => 'created_at',
        'Agent' => function($queryBuilder) {
            $date = array();
            foreach ($queryBuilder->user as $Builder) {
                $date[] = $Builder->name;
            }
            // return json_encode($date);
            return implode(', ', $date);
          },
          'Rating' => function($queryBuilder) {
            return $queryBuilder->rating['rating_value'];
          }
    ];
    $rows =[

    ];
    CSVReport::of($title, $meta, $queryBuilder, $columns)
            ->editColumn('created_at', [ // Change column class or manipulate its data for displaying to report
                'displayAs' => function($result) {
                    return $result->created_at->format('d M Y');
                },
                'class' => 'center'
                ])
            ->showTotal([
                'Rating' => 'point'
                ])
             ->showNumColumn(false)
             ->download($filename);
           }
}
