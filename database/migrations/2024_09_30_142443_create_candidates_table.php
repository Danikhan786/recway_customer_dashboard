<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id(); // Automatically creates an auto-incrementing 'id' field
            $table->string('order_id'); // VARCHAR(255)
            $table->text('vasc_id')->nullable(); // TEXT, nullable because it can be null
            $table->string('security'); // VARCHAR(255)
            $table->string('name'); // VARCHAR(255)
            $table->string('surname'); // VARCHAR(255)
            $table->string('email'); // VARCHAR(255)
            $table->string('phone'); // VARCHAR(255)
            $table->integer('place')->nullable(); // INT(11), nullable
            $table->string('country')->nullable(); // VARCHAR(255), nullable
            $table->text('cv')->nullable(); // TEXT, nullable
            $table->string('referensperson'); // VARCHAR(255)
            $table->string('reference'); // VARCHAR(255)
            $table->text('comment')->nullable(); // TEXT, nullable
            $table->text('note')->nullable(); // TEXT, nullable
            $table->integer('cus_id'); // INT(11)
            $table->integer('staff_id')->default(0); // INT(11) with default value 0
            $table->integer('interview_id'); // INT(11)
            $table->integer('status')->default(0); // INT(11) with default value 0
            $table->date('date')->nullable(); // DATE, nullable
            $table->integer('reported')->default(0); // INT(11) with default value 0
            $table->integer('invoice_sent')->default(0); // INT(11) with default value 0
            $table->date('invoice_date')->nullable(); // DATE, nullable
            $table->integer('economy')->default(-1); // INT(11) with default value -1
            $table->integer('criminal_record')->default(-1); // INT(11) with default value -1
            $table->integer('social')->default(1); // INT(11) with default value 1
            $table->integer('background_checked')->default(0); // INT(11) with default value 0
            $table->timestamp('created')->useCurrent(); // TIMESTAMP, default CURRENT_TIMESTAMP
            $table->date('booked')->nullable(); // DATE, nullable
            $table->integer('expired')->default(0); // INT(11) with default value 0
            $table->date('background_check_date')->nullable(); // DATE, nullable
            $table->date('delivery_date')->nullable(); // DATE, nullable
            $table->text('report')->nullable(); // TEXT, nullable
            $table->integer('report_status')->default(0)
                  ->comment('1=Approved,2=Deviation,3=Denied'); // INT(11) with comment
            $table->text('interview_report')->nullable(); // TEXT, nullable
            $table->integer('dep_user')->nullable(); // INT(11), nullable
            $table->integer('dep_id')->nullable(); // INT(11), nullable
            $table->mediumText('cus_qs_ans')->nullable(); // MEDIUMTEXT, nullable
            $table->mediumText('meta_data')->nullable(); // MEDIUMTEXT, nullable
            $table->integer('reported_to_sm')->nullable(); // INT(11), nullable
            $table->date('reported_to_sm_on')->nullable(); // DATE, nullable
            $table->string('interview_template', 200)->nullable(); // VARCHAR(200), nullable
            $table->string('meta_info', 500)->nullable(); // VARCHAR(500), nullable
            $table->integer('service_cost'); // INT(11)
            $table->integer('travel_cost'); // INT(11)

            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}

