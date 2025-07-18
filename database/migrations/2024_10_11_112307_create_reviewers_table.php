<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviewers', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key (bigint type)
            $table->unsignedBigInteger('cus_id'); // Customer ID as a foreign key (unsigned int)
            $table->string('email', 255); // Email with a length of 255 characters
            $table->string('password', 255); // Password with a length of 255 characters
            $table->timestamps(); // Created at and Updated at timestamps

            // Add a foreign key constraint if `cus_id` references the `customers` table
            // $table->foreign('cus_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviewers');
    }
}
