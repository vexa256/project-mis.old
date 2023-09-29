<?php

namespace App\Http\Controllers;

use DB;
use App\Charts\SystemCharts;
use Illuminate\Http\Request;

class FinanceReportController extends Controller
{
    public function FinRepProject()
    {
        $Projects = DB::table('projects')->get();

        $data = [
            'Title'    => 'Project Selection | Project Finance Summary Report',
            'Desc'     => 'Select project to attach finance report to',
            'Page'     => 'FinRep.SelectProject',
            'Projects' => $Projects,
        ];

        return view('scrn', $data);

    }

    public function FinRepAcceptProject(Request $request)
    {
        $validated = $request->validate([
            '*' => 'required',
        ]);

        $PID = $request->PID;

        return redirect()->route('FinRepSelectModuleAndYear', ['PID' => $PID]);

    }

    public function FinRepSelectModuleAndYear($PID)
    {
        $Modules = DB::table('project_modules', 'MID', $PID)->get();

        $data = [
            'Title'   => 'Module Selection | Project Finance Summary Report',
            'Desc'    => 'Select module and financial year to attach finance report to',
            'Page'    => 'FinRep.SelectYearAndQuarterRanger',
            'PID'     => $PID,
            'Modules' => $Modules,
        ];

        return view('scrn', $data);
    }

    public function FinRepAcceptModule(Request $request)
    {
        $validated = $request->validate([
            '*' => 'required',
        ]);

        $PID  = $request->PID;
        $Year = $request->Year;

        return redirect()->route('FinancialReport', ['PID' => $PID, 'Year' => $Year]);

    }

    public function FinancialReport($PID, $Year)
    {

        $counter = DB::table('project_activity_expenditures')
            ->where('PID', $PID)->where('FinancialYear', $Year)->count();

        if ($counter < 1) {

            return redirect()->route('FinRepProject')->with('status', 'The selected query return zero results. Try another query');
        }

        $Expenditure = DB::table('project_activity_expenditures')
            ->where('PID', $PID)
            ->where('FinancialYear', $Year)
            ->get()->sum('AmountSpentInUsd');

        $Projects = DB::table('projects')->where('PID', $PID)->first();

        $TotalBudget                    = $Projects->TotalBudgetInUsd;
        $TotalGrantInUsd                = $Projects->TotalGrantInUsd;
        $FundDisbursementAtPresentInUsd = $Projects->FundDisbursementAtPresentInUsd;

        $FinancialQuarter = DB::table('project_activity_expenditures')
            ->select(DB::raw('FinancialQuarter, SUM(AmountSpentInUsd) as total_amount_spent', 'project_activity_expenditures.*'))
            ->where('project_activity_expenditures.PID', $PID)
            ->where('project_activity_expenditures.FinancialYear', $Year)
            ->groupBy('FinancialQuarter')
            ->get();

        $GroupByModule = DB::table('project_activity_expenditures')
            ->join('project_modules', 'project_activity_expenditures.MID', '=', 'project_modules.MID')
            ->select('project_modules.ProjectModuleName', DB::raw('SUM(project_activity_expenditures.AmountSpentInUsd) as total'))
            ->groupBy('project_modules.ProjectModuleName')
            ->where('project_activity_expenditures.PID', $PID)
            ->where('project_activity_expenditures.FinancialYear', $Year)
            ->get();

        $GroupByCostGroup = DB::table('project_activity_expenditures')
            ->join('project_modules', 'project_activity_expenditures.MID', '=', 'project_modules.MID')
            ->select('project_activity_expenditures.ExpenditureGroup', DB::raw('SUM(project_activity_expenditures.AmountSpentInUsd) as total'))
            ->groupBy('project_activity_expenditures.ExpenditureGroup')
            ->where('project_activity_expenditures.PID', $PID)
            ->where('project_activity_expenditures.FinancialYear', $Year)
            ->get();

        // dd($GroupByModule);

        // dd($FinancialQuarter);
        $FinancialQuarterChart = new SystemCharts;
        $FinancialQuarterChart->labels($FinancialQuarter->pluck('FinancialQuarter'));
        $FinancialQuarterChart->height(200);

        $FinancialQuarterChart->dataset('Project financial expenditure by quarter analysis (TIMS) for the year ' . $Year, 'bar', $FinancialQuarter->pluck('total_amount_spent'))->backgroundcolor('#75e900');
        $FinancialQuarterChart->dataset('line graph representation', 'line', $FinancialQuarter->pluck('total_amount_spent'))->backgroundcolor('#7e3ff2');

        $Projects = DB::table('projects')->where('PID', $PID)->first();

        $Expenditure = DB::table('project_activity_expenditures')
            ->where('PID', $Projects->PID)
            ->get()->sum('AmountSpentInUsd');

        $graphdata = [
            $Projects->TotalBudgetInUsd,
            $Projects->TotalGrantInUsd,
            $Projects->FundDisbursementAtPresentInUsd,
            $Expenditure,

        ];

        $Expenditure = DB::table('project_activity_expenditures')->where('PID', $Projects->PID)
            ->get()->sum('AmountSpentInUsd');

        $graphdata = [
            $Projects->TotalBudgetInUsd,
            $Projects->TotalGrantInUsd,
            $Projects->FundDisbursementAtPresentInUsd,
            $Expenditure,

        ];

        $data = [
            'Title'                          => 'Project Financial Report For The Financial Year ' . $Year,
            'Desc'                           => 'The project selected ' . $Projects->ProjectName,
            'Page'                           => 'FinRep.FinReport',
            'TotalBudgetInUsd'               => $TotalBudget,
            'TotalGrantInUsd'                => $TotalGrantInUsd,
            'FundDisbursementAtPresentInUsd' => $FundDisbursementAtPresentInUsd,
            'Expenditure'                    => $Expenditure,
            'Year'                           => $Year,
            'FinancialQuarter'               => $FinancialQuarter,
            'GroupByModule'                  => $GroupByModule,
            'GroupByCostGroup'               => $GroupByCostGroup,
            'FinancialQuarterChart'          => $FinancialQuarterChart,
            // 'ModuleChart'                    => $ModuleChart,
        ];

        return view('scrn', $data);
    }

}
