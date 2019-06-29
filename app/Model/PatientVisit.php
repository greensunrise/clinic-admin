<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PatientVisit extends Model
{
    public function location(){
        return $this->hasOne(ClinicLocation::class);
    }

}
