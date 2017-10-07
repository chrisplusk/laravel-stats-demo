<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use \Input;

use \Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //var_dump(Session::get('filter'));
        
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
        
        $selected = json_decode(Session::get('filter'));
        
        return view('home/filter', [
                                'clients' => $clients,
                                'categories' => $categories,
                                'labels' => $labels,
                                'selected_start_date' => $selected->start_date,
                                'selected_end_date' => $selected->end_date,
                                'selected_client_id' => $selected->client_id,
                                'selected_categories' => (is_array($selected->categories) ? $selected->categories : []),
                                'selected_labels' => (is_array($selected->labels) ? $selected->labels : []),
                                'selected_value_equals' => $selected->value_equals,
                                'selected_value' => $selected->value,
                            ]);
    }
    
    public function apply()
    {
        Session::put('filter', json_encode([
            'start_date'    => Input::get('start_date'),
            'end_date'      => Input::get('end_date'),
            'client_id'     => Input::get('client_id'),
            'categories'    => Input::get('categories'),
            'labels'        => Input::get('labels'),
            'value_equals'  => Input::get('value_equals'),
            'value'         => Input::get('value'),
        ]));
        
        return [true];
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
