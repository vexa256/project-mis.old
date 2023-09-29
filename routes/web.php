<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\FinanceReportController;

Route::middleware(['auth'])->group(function () {
    Route::controller(MainController::class)->group(function () {

        Route::any('VirtualOffice', 'VirtualOffice')->name('VirtualOffice');
        Route::any('/home', 'VirtualOffice')->name('home');
        // Route::any('/dashboard', 'VirtualOffice')->name('dashboard');

    });

    Route::controller(FinanceReportController::class)->group(function () {

        Route::get('FinancialReport/{PID}/{Year}', 'FinancialReport')->name('FinancialReport');

        Route::post('FinRepAcceptModule', 'FinRepAcceptModule')->name('FinRepAcceptModule');

        Route::get('FinRepSelectModuleAndYear/{PID}', 'FinRepSelectModuleAndYear')->name('FinRepSelectModuleAndYear');

        Route::get('FinRepProject', 'FinRepProject')->name('FinRepProject');

        Route::post('FinRepAcceptProject', 'FinRepAcceptProject')->name('FinRepAcceptProject');

    });
    Route::controller(ReportsController::class)->group(function () {

        Route::get('TechMgtProjectActivities/{PID}/{MID}', 'TechMgtProjectActivities')->name('TechMgtProjectActivities');

        Route::post('TechAcceptActivityModule', 'TechAcceptActivityModule')->name('TechAcceptActivityModule');

        Route::get('TechActivityProjectModule/{PID}', 'TechActivityProjectModule')->name('TechActivityProjectModule');

        Route::post('TechAcceptProjectActivities', 'TechAcceptProjectActivities')->name('TechAcceptProjectActivities');

        Route::get('TechSelectActivityProject', 'TechSelectActivityProject')->name('TechSelectActivityProject');

    });

    Route::controller(AnalyticsController::class)->group(function () {

        Route::post('AcceptModExYear', 'AcceptModExYear')->name('AcceptModExYear');

        Route::get('ModuleFinancialAnalyis/{Year}', 'ModuleFinancialAnalyis')->name('ModuleFinancialAnalyis');

        Route::get('ModuleExpenditureYear', 'ModuleExpenditureYear')->name('ModuleExpenditureYear');

        Route::get('/', 'GeneralDashboard')->name('GeneralDashboard');
        Route::get('GeneralDashboard', 'GeneralDashboard')->name('GeneralDashboard');
        Route::get('dashboard', 'GeneralDashboard')->name('GeneralDashboard');
    });

    Route::controller(ProjectController::class)->group(function () {

        Route::get('MgtActivityExpenditure/{MID}', 'MgtActivityExpenditure')->name('MgtActivityExpenditure');

        Route::get('MgtExpenditureCategories', 'MgtExpenditureCategories')->name('MgtExpenditureCategories');

        Route::post('AcceptActivityModuleActivity', 'AcceptActivityModuleActivity')->name('AcceptActivityModuleActivity');

        Route::post('ExpenditureSelectModule', 'ExpenditureSelectModule')->name('ExpenditureSelectModule');

        Route::get('ExpenditureSelectProject', 'ExpenditureSelectProject')->name('ExpenditureSelectProject');

        Route::get('ModuleSelectProject', 'ModuleSelectProject')->name('ModuleSelectProject');

        Route::get('MgtProjectModules/{PID}', 'MgtProjectModules')->name('MgtProjectModules');

        Route::post('AcceptProjectModule', 'AcceptProjectModule')->name('AcceptProjectModule');

        Route::get('MgtProjects', 'MgtProjects')->name('MgtProjects');

        Route::get('SelectActivityProject', 'SelectActivityProject')->name('SelectActivityProject');

        Route::post('AcceptProjectActivities', 'AcceptProjectActivities')->name('AcceptProjectActivities');

        Route::get('MgtProjectActivities/{PID}/{MID}', 'MgtProjectActivities')->name('MgtProjectActivities');

        Route::get('ActivityProjectModule/{PID}', 'ActivityProjectModule')->name('ActivityProjectModule');

        Route::post('AcceptActivityModule', 'AcceptActivityModule')->name('AcceptActivityModule');

    });

    Route::controller(CrudController::class)->group(function () {
        Route::get('DeleteData/{id}/{TableName}', 'DeleteData')->name(
            'DeleteData'
        );

        Route::post('MassUpdate', 'MassUpdate')->name('MassUpdate');

        Route::post('MassInsert', 'MassInsert')->name('MassInsert');
    });
});

require __DIR__ . '/auth.php';
