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
        return view('home/index');
    }
    
    public function seed()
    {
        $exitCode = \Artisan::call('db:seed', [
            '--class' => 'StatsSeeder'
        ]);
        
        return [$exitCode];
    }
    
    private function getSelection()
    {
        return json_decode(Session::get('filter')) ?: new class {
            public $start_date  = '',
                $end_date       = '',
                $client_id      = 0,
                $categories     = [],
                $labels         = [],
                $value_equals   = '',
                $value          = '';
        };
    }
    
    private function applyFilter($query)
    {
        $selected = $this->getSelection();
        
        if (false === empty($selected->start_date))
        {
            $query->where('date', '>=', date('Y-m-d H:i:s',strtotime($selected->start_date)));
        }
        if (false === empty($selected->end_date))
        {
            $query->where('date', '<=', date('Y-m-d 23:59:59',strtotime($selected->end_date)));
        }
        
        if ($selected->client_id != 0)
        {
            
            $query->where('client_id', '=', $selected->client_id);
        }
        
        if (is_array($selected->categories) && false == empty($selected->categories))
        {
            $query->whereIn('category_id', $selected->categories);
        }
        
        if (is_array($selected->labels) && false == empty($selected->labels))
        {
            $query->whereIn('label_id', $selected->labels);
        }
        
        if (false === empty($selected->value))
        {
            $query->where('value', $selected->value_equals == 'ltoe' ? '<=' : '>=', $selected->value);
        }
        
        return $query;
    }
    
    public function table()
    {
        if (false === empty(Input::get('sortBy')))
        {
            if (Session::has('sortBy') && Session::get('sortBy') == Input::get('sortBy'))
            {
                Session::put('sortDir', Session::get('sortDir') == 'asc' ? 'desc' : 'asc');
            }
            else
            {
                Session::put('sortBy', Input::get('sortBy'));
                Session::put('sortDir', 'asc');
            }
        }
        
        $stats = $this->applyFilter( DB::table('stats_'.date('Y').'_'.date('m')) );
        
        if (Session::has('sortBy') && Session::has('sortDir'))
        {
            $stats->orderBy(Session::get('sortBy'), Session::get('sortDir'));
        }

        return view('home/partials/table', [
                                'stats' => $stats->get(),
                                'sortBy' => Session::has('sortBy') ? Session::get('sortBy') : '',
                                'sortDir' => Session::has('sortDir') ? Session::get('sortDir') : ''
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
        
        $selected = $this->getSelection();
        
        return view('home/partials/filter', [
                                'clients' => $clients,
                                'categories' => $categories,
                                'labels' => $labels,
                                'selected_start_date'   => $selected->start_date,
                                'selected_end_date'     => $selected->end_date,
                                'selected_client_id'    => $selected->client_id,
                                'selected_categories'   => (is_array($selected->categories) ? $selected->categories : []),
                                'selected_labels'       => (is_array($selected->labels) ? $selected->labels : []),
                                'selected_value_equals' => $selected->value_equals,
                                'selected_value'        => $selected->value,
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
        $stats = $this->applyFilter( DB::table('stats_'.date('Y').'_'.date('m'))
            ->select('category_id', DB::raw('SUM(value) as value'))
            ->groupBy('category_id') )
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
        $stats = $this->applyFilter( DB::table('stats_'.date('Y').'_'.date('m'))
            ->select('label_id', DB::raw('SUM(value) as value'))
            ->groupBy('label_id') )
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
        $stats = $this->applyFilter( DB::table('stats_'.date('Y').'_'.date('m')) )->get();

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
