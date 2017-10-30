<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    
    public function table()
    {
        $stats = \App\Stats::select( $this->getSelection() )->get();
        
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
        $selected   = $this->getSelection();
        
        $clients    = \App\Stats::getClients();
        
        $categories = \App\Stats::getCategories();
        
        $labels     = \App\Stats::getLabels();
        
        return view('home/partials/filter', [
                                'clients'               => $clients,
                                'categories'            => $categories,
                                'labels'                => $labels,
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
        $stats = \App\Stats::select( $this->getSelection() )->getValueGroupedByCategory();

        $labels = [];
        $values = [];
        
        foreach($stats->get() as $row)
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
        $stats = \App\Stats::select( $this->getSelection() )->getValueGroupedByLabel();
        
        $labels = [];
        $values = [];
        
        foreach($stats->get() as $row)
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
        $stats = \App\Stats::select( $this->getSelection() )->getValueGroupedByDay();
        
        $labels = [];
        $values = [];
        
        foreach($stats->get() as $row)
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
