<?php

namespace App\Admin\Controllers;

use App\Model\Procedure;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProcedureController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Procedure register';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Procedure);

        $grid->model()->where('patient_visit_id','=',request()->segment(5));

        $grid->column('procedure_name', __('Procedure name'));
        $grid->column('cost', __('Cost'));
        $grid->column('created_at', __('Procedure performed at'));

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableView();
            $actions->disableEdit();
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
        $show = new Show(Procedure::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('procedure_name', __('Procedure name'));
        $show->field('description', __('Description'));
        $show->field('duration', __('Duration'));
        $show->field('started_at', __('Started at'));
        $show->field('completed_at', __('Completed at'));
        $show->field('cost', __('Cost'));
        $show->field('patient_visit_id', __('Patient visit id'));
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
        $form = new Form(new Procedure);

        $form->text('procedure_name', __('Procedure name'));
        $form->textarea('description', __('Description'));
        $form->time('duration', __('Duration'))->default(date('H:i:s'));
        $form->datetime('started_at', __('Started at'))->default(date('Y-m-d H:i:s'));
        $form->datetime('completed_at', __('Completed at'))->default(date('Y-m-d H:i:s'));
        $form->decimal('cost', __('Cost'))->default(0.00);
        $form->hidden('patient_visit_id')->value(request()->segment(5));

        return $form;
    }
}
