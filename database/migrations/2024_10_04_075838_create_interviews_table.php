<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->bigIncrements('id'); // Automatically creates `id` as a primary key (int, auto-increment).
            $table->integer('service_cat_id')->unsigned();
            $table->text('title');
            $table->text('desc')->nullable(); // Optional (nullable) text field.
            $table->integer('country')->unsigned();
            $table->integer('place')->unsigned();
            $table->integer('cost')->unsigned();
            $table->timestamps(); // Adds `created_at` and `updated_at` columns.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interviews');
    }
}
