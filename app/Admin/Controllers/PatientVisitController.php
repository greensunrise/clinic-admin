<?php

namespace App\Admin\Controllers;

use App\Model\ClinicLocation;
use App\Model\Patient;
use App\Model\PatientVisit;
use App\User;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PatientVisitController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Patient visit register';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid( new PatientVisit);

        $grid->model()->where('patient_id','=',request()->segment(3));

        $grid->column('created_at', __('Registered date'));
        $grid->column('location.location_name', __('Location'));
        $grid->column('registeredby.name', __('Registered by'));
        $grid->column('treatedby.name', __('Treated by'));
        $grid->column('Total cost')->display(function (){

            $procedures= $this->procedures->sum('cost');

            return $procedures;

        });
        $grid->column('Patient Full Name')->display(function (){

            $patient= $this->patient;
            return $patient->first_name. ' '. trim(($patient->surname ?? '') .' '.$patient->surname);

        });

        $grid->actions(function (Grid\Displayers\Actions $actions) {

            $addNewProcedureUrl = $actions->getResource().'/'.$actions->getRouteKey().'/procedures/create';
            $addNewProcedureUrl= str_replace('//','/',$addNewProcedureUrl);

            $viewProcedureUrl = $actions->getResource().'/'.$actions->getRouteKey().'/procedures';
            $viewProcedureUrl= str_replace('//','/',$viewProcedureUrl);

            $actions->prepend('<a style="margin-left:15px" class="btn btn-sm btn-success" href="'.$addNewProcedureUrl.'"> Add new procedure</a>');
            $actions->prepend('<a class="btn btn-sm btn-success" href="'.$viewProcedureUrl.'"> View procedures</a>');

            $actions->disableDelete();
            $actions->disableView();

        });



        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(PatientVisit::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field($this->location()->name, __('Location'));
        $show->field('registered_by', __('Registered by'));
        $show->field('treated_by', __('Treated by'));
        $show->field('patient_id', __('Patient id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $patientId= request()->segment(3);
        Patient::findOrFail($patientId);
        $form = new Form(new PatientVisit);

        $allLocations= ClinicLocation::all(['id','location_name'])->toArray();

        $locations= array_column($allLocations,'location_name','id');

        $form->select('location_id')
            ->options($locations)
            ->default($allLocations[0]['id'] ??'')
            ->required()->setWidth(2);
;

        $allUsers = Administrator::whereHas('roles',  function ($query) {
            $query->whereIn('name', ['Doctor']);
        })->get(['id','name'])->toArray();


        $users= array_column($allUsers,'name','id');

        $form->select('treated_by','Assigned to')->options($users)->setWidth(2);
        $form->hidden('patient_id')->value($patientId);

        return $form;
    }



}
