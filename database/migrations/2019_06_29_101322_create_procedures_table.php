<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('procedure_name')->nullable(false);
            $table->text('description')->nullable()->default(null);
            $table->time('duration')->nullable()->default(null);
            $table->dateTime('started_at')->nullable()->default(null);
            $table->dateTime('completed_at')->nullable()->default(null);
            $table->decimal('cost')->default(0.0)->nullable(false);
            $table->unsignedBigInteger('patient_visit_id');
            $table->foreign('patient_visit_id')
                ->on('patient_visits')
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
        Schema::dropIfExists('procedures');
    }
}
