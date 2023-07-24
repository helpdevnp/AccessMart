<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDMVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_m_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->double('starting_coverage_area',16,2);
            $table->double('maximum_coverage_area',16,2);
            $table->double('extra_charges',16,2);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_m_vehicles');
    }
}
