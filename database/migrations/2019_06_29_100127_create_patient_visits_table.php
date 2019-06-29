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
            $table->bigIncrements('id');

            $table->unsignedBigInteger('location_id');
            $table->foreign('location_id')
                ->on('clinic_locations')
                ->references('id');

            $table->unsignedBigInteger('registered_by');
            $table->foreign('registered_by')
                ->on('users')
                ->references('id');

            $table->unsignedBigInteger('treated_by');
            $table->foreign('treated_by')
                ->on('users')
                ->references('id');

            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')
                ->on('patients')
                ->references('id');


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
        Schema::dropIfExists('model_patients_visits');
    }
}
