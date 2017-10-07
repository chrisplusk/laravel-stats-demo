<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home/index');
    }
    
    public function table()
    {
        
        $stats = DB::table('stats_'.date('Y').'_'.date('m'))->get();
        
        return view('home/table', [
                                'stats' => $stats,
                            ]);
    }
    
    public function filter()
    {
        $clients = DB::table('stats_'.date('Y').'_'.date('m'))
            ->select('client_id')
            ->groupBy('client_id')
            ->get();
        $categories = DB::table('stats_'.date('Y').'_'.date('m'))
            ->select('category_id')
            ->groupBy('category_id')
            ->get();
        $labels = DB::table('stats_'.date('Y').'_'.date('m'))
            ->select('label_id')
            ->groupBy('label_id')
            ->get();
        
        return view('home/filter', [
                                'clients' => $clients,
                                'categories' => $categories,
                                'labels' => $labels,
                            ]);
    }
    
    public function doughnut()
    {
        $stats = DB::table('stats_'.date('Y').'_'.date('m'))
            ->select('category_id', DB::raw('SUM(value) as value'))
            ->groupBy('category_id')
            ->get();

        $labels = [];
        $values = [];
        
        foreach($stats as $row)
        {
            $labels[] = $row->category_id;
            $values[] = $row->value;
        }
        
        return response()->json([
                    'labels' => $labels,
                    'values' => $values,
                ]);
    }
    
    public function bar()
    {
        $stats = DB::table('stats_'.date('Y').'_'.date('m'))
            ->select('label_id', DB::raw('SUM(value) as value'))
            ->groupBy('label_id')
            ->get();

        $labels = [];
        $values = [];
        
        foreach($stats as $row)
        {
            $labels[] = $row->label_id;
            $values[] = $row->value;
        }
        
        return response()->json([
                    'labels' => $labels,
                    'values' => $values,
                ]);
    }
    
    public function line()
    {
        $stats = DB::table('stats_'.date('Y').'_'.date('m'))->get();

        $labels = [];
        $values = [];
        
        foreach($stats as $row)
        {
            $labels[] = $row->day;
            $values[] = $row->value;
        }
        
        return response()->json([
                    'labels' => $labels,
                    'values' => $values,
                ]);
    }
}
