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
        $now    = date('Y-m-d H:i:s');
        $date   = date('Y-m-01 00:00:00'); //TODO: select latest date from table

        while ( strtotime($date) < strtotime($now) && date('m',strtotime($date)) <= date('m', strtotime($now)) )
        {
            $date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', strtotime($date)) . ' +1 hour') );
            
            DB::table('stats_'.date('Y').'_'.date('m'))->insert([
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
