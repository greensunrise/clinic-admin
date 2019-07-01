<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Patient extends Model
{

    public static function boot()
    {
        parent::boot();

        static::creating(function(Patient $patient){
            $patient->uuid = Uuid::uuid4()->serialize();
        });
    }

    public function patientvisits(){
        return $this->hasMany(PatientVisit::class);
    }

    public function getTotalCost(){


    }
}
