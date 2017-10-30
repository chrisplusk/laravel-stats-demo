<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Stats
{
    private $selection;
    
    public function __construct($selection)
    {
        $this->selection = $selection;
    }
    
    public static function select($selection)
    {
        return new self($selection);
    }
    
    public function get()
    {
        $stats = $this->unionMonths(function ($date) {
            return $this->filter( DB::table( 'stats_'.date('Y_m',strtotime($date)) ) );
        });
        
        return $stats;
    }
    
    public function getValueGroupedByCategory()
    {
        $unions = $this->unionMonths(function ($date) {
            return $this->filter(
                DB::table( 'stats_'.date('Y_m',strtotime($date)) )
                    ->select('category_id', DB::raw('SUM(value) as value'))
                    ->groupBy('category_id')
            );
        });
        
        $stats = DB::table( DB::raw("(".$unions->toSql().") as unions GROUP BY category_id") )
                    ->mergeBindings($unions)
                    ->select('category_id', DB::raw('SUM(value) as value'));
        
        return $stats;
    }
    
    public function getValueGroupedByLabel()
    {
        $unions = $this->unionMonths(function ($date) {
            return $this->filter(
                DB::table( 'stats_'.date('Y_m',strtotime($date)) )
                    ->select('label_id', DB::raw('SUM(value) as value'))
                    ->groupBy('label_id') );
        });

        $stats = DB::table( DB::raw("(".$unions->toSql().") as unions GROUP BY label_id") )
                    ->mergeBindings($unions)
                    ->select('label_id', DB::raw('SUM(value) as value'));
        
        return $stats;
    }
    
    public function getValueGroupedByDay()
    {
        $stats = $this->unionMonths(function ($date) {
            return $this->filter(
                DB::table( 'stats_'.date('Y_m',strtotime($date)) )
                    ->select('day', DB::raw('SUM(value) as value'))
                    ->groupBy('day') );
        });
        
        return $stats;
    }
    
    public static function getClients()
    {
        return DB::table('stats_'.date('Y_m'))
            ->select('client_id')
            ->groupBy('client_id')
            ->get();
    }
    public static function getCategories()
    {
        return DB::table('stats_'.date('Y_m'))
            ->select('category_id')
            ->groupBy('category_id')
            ->get();
    }
    public static function getLabels()
    {
        return DB::table('stats_'.date('Y_m'))
            ->select('label_id')
            ->groupBy('label_id')
            ->get();
    }
    
    private function filter($query)
    {
        $selected = $this->selection;
        
        if (false === empty($selected->start_date))
        {
            $query->where('date', '>=', date('Y-m-d H:i:s', strtotime($selected->start_date)));
        }
        if (false === empty($selected->end_date))
        {
            $query->where('date', '<=', date('Y-m-d 23:59:59', strtotime($selected->end_date)));
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
    
    private function unionMonths($query)
    {
        $selected = $this->selection;

        if (false === empty($selected->start_date) && false === empty($selected->end_date))
        {
            $date   = date('Y-m-01 H:i:s', strtotime($selected->start_date));
            $end    = date('Y-m-01 H:i:s', strtotime($selected->end_date));
        }
        else
        {
            $date   = date('Y-m-01 00:00:00');
            $end    = date('Y-m-01 00:00:00');
        }

        $union = $query($date);

        while ( strtotime($date) < strtotime($end) )
        {
            $date = date('Y-m-d H:i:s', strtotime($date . ' +1 month') );

            $union->unionAll( $query($date) );
        }
        
        return $union;
    }
}