<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Procedures extends Model
{
    public function patientvisit(){

        return $this->belongsTo(PatientVisit::class);
    }
}
