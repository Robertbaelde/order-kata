<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_events', function (Blueprint $table) {
            $table->uuid('event_id')->primary();
            $table->string('aggregate_root_id', 100)->index();
            $table->unsignedInteger('version');
            $table->text('payload');
            $table->dateTime('recorded_at', 6)->index();
            $table->string('event_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_events');
    }
};
