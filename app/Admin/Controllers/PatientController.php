<?php

namespace App\Admin\Controllers;

use App\Model\Patient;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Show;

class PatientController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Patients';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Patient);

        $grid->column('uuid','UUID');

        $grid->column('Full Name')->display(function () {
            return $this->first_name.' '.($this->middle_name ?? '').' '.$this->surname;
        });

        $grid->column('Total cost (all visit)')->display(function ($comments) {

            $patientVisits= $this->patientvisits;
            $totalCosts=0.0;
            foreach ($patientVisits as $patientVisit ){
                $totalCosts += $patientVisit->procedures->sum('cost');
            }

            return $totalCosts;
        });

        $grid->column('phone_number');

        $grid->column('age', __('Age'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {

            $addNewVisitUrl = $actions->getResource().'/'.$actions->getRouteKey().'/patient-visits/create';
            $addNewVisitUrl= str_replace('//','/',$addNewVisitUrl);

            $viewVisitUrl = $actions->getResource().'/'.$actions->getRouteKey().'/patient-visits';
            $viewVisitUrl= str_replace('//','/',$viewVisitUrl);

            $editVisitUrl = $actions->getResource().'/'.$actions->getRouteKey().'/edit';
            $editVisitUrl= str_replace('//','/',$editVisitUrl);


            $actions->prepend('<a style="margin-left:15px" class="btn btn-sm btn-success" href="'.$addNewVisitUrl.'"> Add new visit</a>');
            $actions->prepend('<a class="btn btn-sm btn-success" href="'.$viewVisitUrl.'"> View visits</a>');
            $actions->append('<a style="margin-left:15px" class="btn btn-sm btn-warning" href="'.$editVisitUrl.'"> Edit</a>');

            $actions->disableDelete();
            $actions->disableView();
            $actions->disableEdit();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param  mixed  $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Patient::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('first_name', __('First name'));
        $show->field('middle_name', __('Middle name'));
        $show->field('surname', __('Surname'));
        $show->field('age', __('Age'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Patient);

        $form->text('first_name', __('First name'));
        $form->text('middle_name', __('Middle name'));
        $form->text('surname', __('Surname'));
        $form->decimal('age', __('Age'));
        $form->text('phone_number')->setWidth(2);

        return $form;
    }
}
