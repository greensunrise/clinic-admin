<?php


namespace App\Model;


use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Model;

class PatientVisit extends Model
{
    public function location()
    {
        return $this->hasOne(ClinicLocation::class,'id','location_id');
    }

    public function registeredby(){

        return $this->hasOne(Administrator::class,'id','registered_by');
    }

    public function treatedby(){

        return $this->hasOne(Administrator::class,'id','treated_by');
    }

    public function patient(){

        return $this->hasOne(Patient::class,'id','patient_id');
    }

    public function procedures(){

        return $this->hasMany(Procedure::class);
    }


    public static function boot()
    {

        parent::boot();
        static::creating(function (PatientVisit $patientVisit) {

            $patientVisit->registered_by = Admin::user()->id;

        });


    }

}
