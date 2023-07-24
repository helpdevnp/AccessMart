<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaximumDeliveryChargeColumnToModuleZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('module_zone', function (Blueprint $table) {
            $table->double('maximum_shipping_charge', 23, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('module_zone', function (Blueprint $table) {
            $table->dropColumn('maximum_shipping_charge');
        });
    }
}
