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
        $stats_yyyy_mm = 'stats_'.date('Y').'_'.date('m');
        
        if (false === Schema::hasTable($stats_yyyy_mm)) {
            DB::statement('CREATE TABLE '.$stats_yyyy_mm.' LIKE stats_yyyy_mm');
        }
        
        $table = DB::table($stats_yyyy_mm);
        
        $now    = date('Y-m-d H:i:s');

        $date = $table->max('date') ?: date('Y-m-01 00:00:00');
        
        while ( strtotime($date) < strtotime($now) )
        {
            $date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', strtotime($date)) . ' +1 hour') );
            
            $table->insert([
                'day'           => date('d', strtotime($date)),
                'hour'          => date('H', strtotime($date)),
                'date'          => date('Y-m-d H:i:s', strtotime($date)),
                'client_id'     => random_int(1,2),
                'category_id'   => random_int(1,3),
                'label_id'      => random_int(0,10),
                'value'         => random_int(0,1000),
            ]);
        }
    }
}
