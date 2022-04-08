<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pcr_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('period_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('department_id');
            $table->char('employee_type');
            $table->char('form_type');
            $table->unsignedBigInteger('employee_id_immediate_supervisor')->nullable();
            $table->string('full_name_immediate_supervisor')->nullable();
            $table->unsignedBigInteger('employee_id_department_head')->nullable();
            $table->string('full_name_department_head')->nullable();
            $table->unsignedBigInteger('employee_id_head_of_agency')->nullable();
            $table->string('full_name_head_of_agency')->nullable();
            $table->dateTime('date_submitted')->nullable();
            $table->dateTime('date_approved')->nullable();
            $table->dateTime('date_certified')->nullable();
            $table->json('record_logs')->nullable();
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
        Schema::dropIfExists('pcr_records');
    }
};
