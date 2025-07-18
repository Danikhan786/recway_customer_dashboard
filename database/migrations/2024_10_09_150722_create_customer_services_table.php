<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_services', function (Blueprint $table) {
            // Ensure both are unsignedBigInteger if the customers and services tables use it
            $table->unsignedBigInteger('cus_id');
            $table->unsignedBigInteger('service_id');
            $table->integer('service_cost');
            
            // Add foreign key relationships
            // $table->foreign('cus_id')->references('id')->on('customers')->onDelete('cascade');
            // $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */ 
    public function down()
    {
        Schema::dropIfExists('customer_services');
    }
}
