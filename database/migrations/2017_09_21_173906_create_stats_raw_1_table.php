<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatsRaw1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stats_raw_1', function (Blueprint $table) {
            $table->datetime('date');
            $table->integer('client_id');
            $table->integer('category_id');
            $table->integer('label_id');
            $table->integer('value');
        });
        
        DB::statement("ALTER TABLE `stats_raw_0` comment 'insert into during uneven, aggregate during even hours'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stats_raw_1');
    }
}
