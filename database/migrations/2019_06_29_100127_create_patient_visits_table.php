<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_visits', function (Blueprint $table) {

            $adminUserTable = config('admin.database.users_table');
            $table->bigIncrements('id');

            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')
                ->on('clinic_locations')
                ->references('id');

            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')
                ->on('patients')
                ->references('id');


            $table->unsignedInteger('registered_by')->nullable();
            $table->foreign('registered_by')
                ->references('id')
                ->on($adminUserTable);

            $table->unsignedInteger('treated_by')->nullable();
            $table->foreign('treated_by')
                ->references('id')
                ->on($adminUserTable);


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

    }
}
