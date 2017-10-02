<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatsYyyyMmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats_yyyy_mm', function (Blueprint $table) {
            $table->tinyInteger('day')->unsigned();
            $table->tinyInteger('hour')->unsigned();
            $table->datetime('date');
            $table->integer('client_id');
            $table->integer('category_id');
            $table->integer('label_id');
            $table->integer('value');
            
            $table->primary(['day', 'hour', 'client_id', 'category_id', 'label_id'], 'stats_yyyy_mm_primary');
            $table->index('day');
            $table->index('hour');
            $table->index('client_id');
            $table->index('category_id');
            $table->index('label_id');
        });
        
        DB::statement("ALTER TABLE `stats_raw_0` comment 'blueprint table - aggregated per day per hour for year yyyy month mm'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stats_yyyy_mm');
    }
}
