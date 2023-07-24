<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('react_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->string('designation',100)->nullable();
            $table->text('review')->nullable();
            $table->string('reviewer_image')->nullable();
            $table->string('company_image')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('react_testimonials');
    }
}
