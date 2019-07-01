<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('patients', PatientController::class);
    $router->resource('clinic-locations', ClinicLocationController::class);
    $router->resource('patients/{patientId}/patient-visits/{visitId}/procedures', ProcedureController::class);
    $router->resource('patients/{patientId}/patient-visits', PatientVisitController::class);
    $router->resource('financial-reports', FinancialReportingController::class);

});
