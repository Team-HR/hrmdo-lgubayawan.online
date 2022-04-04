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
        Schema::table('employees', function (Blueprint $table) {
            $table->text('gender')->after('ext_name')->nullable();
            $table->text('is_active')->after('gender')->nullable();
            $table->text('status')->after('is_active')->nullable();
            $table->text('position_id')->after('department_id')->nullable();
            $table->text('nature_of_assignment')->after('position_id')->nullable();
            $table->date('date_activated')->after('nature_of_assignment')->nullable();
            $table->date('date_inactivated')->after('date_activated')->nullable();
            $table->date('date_ipcr')->after('date_inactivated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'is_active',
                'status',
                'position_id',
                'nature_of_assignment',
                'date_activated',
                'date_inactivated',
                'date_ipcr'
            ]);
        });
    }
};
