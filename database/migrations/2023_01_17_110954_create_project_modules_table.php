<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_modules', function (Blueprint $table) {
            $table->id();
            $table->string('PID');
            $table->string('MID');
            $table->string('ProjectModuleName');
            $table->string('Description');
            $table->longText('Objectives');
            $table->float('TotalBudgetInUsd')->nullable();
            $table->float('BudgetAmountSpentAtPresent')->nullable();
            $table->float('BudgetAmountAvailable')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_modules');
    }
};
