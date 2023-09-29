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
        Schema::create('project_activity_expenditures', function (Blueprint $table) {
            $table->id();
            $table->string('PID');
            $table->string('MID');
            $table->string('AID');
            $table->string('EID');
            $table->string('ExpenditureGroup');
            $table->string('ExpenditureNarrative');
            $table->string('BudgetLine');
            $table->float('AmountSpentInUsd');
            // $table->string('StartDate');
            // $table->string('EndDate');
            $table->string('FinancialQuarter');
            $table->string('FinancialYear');
            $table->string('ExpectedOutComes');
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
        Schema::dropIfExists('project_activity_expenditures');
    }
};
