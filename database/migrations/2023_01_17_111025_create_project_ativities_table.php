<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_ativities', function (Blueprint $table) {
            $table->id();
            $table->string('ActivityName')->nullable();
            $table->string('ActivityDescription')->nullable();
            $table->string('ActivityObjectives')->nullable();
            $table->string('PID');
            $table->string('MID');
            $table->string('AID');
            $table->float('FinancialQuater');
            $table->float('FinancialYear');
            $table->string('BudgetLine')->nullable();
            $table->date('StartDate')->nullable();
            $table->date('EndDate')->nullable();
            $table->string('ProgressStatus')->default('pending');
            $table->string('Comments')->default('NA');
            $table->float('ActivityBudgetInUsd')->nullable();

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
        Schema::dropIfExists('project_ativities');
    }
};
