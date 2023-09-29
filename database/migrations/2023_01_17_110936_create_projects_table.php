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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('PID');
            $table->string('ProjectName');
            $table->string('ProjectDescription');
            $table->string('ApplicantOrCountry');
            $table->string('PrincipalRecipient');
            $table->string('GrantNumber');
            $table->string('GrantName');
            $table->float('TotalBudgetInUsd')->nullable();
            $table->float('TotalGrantInUsd')->nullable();
            $table->float('FundDisbursementAtPresentInUsd')->nullable();
            $table->float('ProjectExpenditureAtPresentInUsd')->nullable();
            $table->float('AvailableFundInUsd')->nullable();
            $table->longText('ProjectDetails')->nullable();
            $table->float('VarianceInUsdAtPresent')->nullable();
            $table->float('FundsAvailableAtPresentInUsd')->nullable();
            $table->date('ImplementationStartDate');
            $table->date('ImplementationEndDate');
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
        Schema::dropIfExists('projects');
    }
};
