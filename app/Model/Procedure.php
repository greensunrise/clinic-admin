<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    public function patientvisit(){

        return $this->hasOne(PatientVisit::class);
    }
}
