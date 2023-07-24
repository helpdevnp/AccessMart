<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCutleryProcessingTimeUnavailableProductNoteColToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('processing_time',10)->nullable();
            $table->string('unavailable_item_note', 255)->nullable();
            $table->boolean('cutlery')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('processing_time');
            $table->dropColumn('unavailable_item_note');
            $table->dropColumn('cutlery');
        });
    }
}
