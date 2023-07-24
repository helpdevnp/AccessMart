<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByColumnsToCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->string('created_by',50)->default('admin')->nullable();
            $table->string('customer_id')->default(json_encode(['all']))->nullable();
            $table->string('slug',255)->nullable();
            $table->foreignId('store_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('created_by');
            $table->dropColumn('slug');
            $table->dropColumn('customer_id');
            $table->dropColumn('store_id');
        });
    }
}
