<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id'); // Primary key, auto-incrementing
            $table->string('variable'); // VARCHAR(255)
            $table->string('status'); // VARCHAR(255)
            $table->text('status_detail')->nullable(); // TEXT, nullable field
            $table->text('status_icon')->nullable(); // TEXT, nullable field
            $table->string('color'); // VARCHAR(255)
            $table->string('email_to')->comment('1=admin, 2=customer, 3=candidate'); // VARCHAR(255) with comment
            $table->integer('status_type')->nullable(); // INT(11), nullable field
            $table->timestamps(); // Adds created_at and updated_at fields
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
