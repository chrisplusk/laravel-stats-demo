<?php

use Illuminate\Database\Seeder;

class StatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now    = date('Y-m-d H:00:00');

        $mm     = date('Y-01-01 00:00:00');
        
        while ( strtotime($mm) < strtotime($now) )
        {
            $to     = date('Y-m-d 23:00:00', strtotime($mm . ' +1 month -1 day') );
            
            if ($to > $now)
            {
                $to = $now;
            }
            
            $this->fillMonth($mm, $to);
            
            $mm     = date('Y-m-01 00:00:00', strtotime($mm . ' +1 month') );
        }
    }
    
    private function fillMonth($from, $to)
    {
        $stats_yyyy_mm = 'stats_'.date('Y_m', strtotime($from));
        
        if (false === Schema::hasTable($stats_yyyy_mm)) {
            DB::statement('CREATE TABLE '.$stats_yyyy_mm.' LIKE stats_yyyy_mm');
        }
        
        $table = DB::table($stats_yyyy_mm);
        
        $max = $table->max('date');
        
        if (strtotime($max) == strtotime($to))
            return;

        $date = $max ?: $from;

        while ( strtotime($date) <= strtotime($to) )
        {
            $table->insert([
                'day'           => date('d', strtotime($date)),
                'hour'          => date('H', strtotime($date)),
                'date'          => date('Y-m-d H:i:s', strtotime($date)),
                'client_id'     => random_int(1,2),
                'category_id'   => random_int(1,3),
                'label_id'      => random_int(0,10),
                'value'         => random_int(0,1000),
            ]);
            
            $date = date('Y-m-d H:i:s', strtotime($date . ' +1 hour') );
        }
    }
}
