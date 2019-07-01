<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ClinicLocation extends Model
{
    //


    public function patientvisits(){

        return $this->hasMany(PatientVisit::class);
    }
}
