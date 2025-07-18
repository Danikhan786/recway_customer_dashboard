<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('company')->nullable(); // Added field
            $table->text('cost_place')->nullable(); // Added field
            $table->string('email')->unique();
            $table->string('phone')->nullable(); // Added field
            $table->string('password');
            $table->string('statuses')->nullable(); // Added field
            $table->boolean('send_security_report')->default(false); // Added field
            $table->integer('report_delete_duration')->nullable(); // Added field
            $table->string('groups', 1100)->nullable(); // Added field
            $table->mediumText('reg_email')->nullable(); // Added field
            $table->unsignedBigInteger('parent_id')->nullable(); // Added field
            $table->unsignedBigInteger('dep_id')->nullable(); // Added field
            $table->unsignedBigInteger('interview_template')->nullable(); // Added field
            $table->boolean('interviewed')->default(false); // Added field
            $table->string('remainder_email')->nullable(); // Added field
            $table->string('remainder_email_template')->nullable(); // Added field
            $table->integer('sent_email')->default(0); // Added field
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
