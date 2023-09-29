<?php

namespace App\Http\Controllers;

use DB;
use App\Charts\SystemCharts;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{

    public function __construct()
    {

        $Projects = DB::table('projects')->get();

        foreach ($Projects as $data) {

            $Modules = DB::table('project_modules')->where('PID', $data->PID)->get();

            DB::table('projects')->where('PID', $data->PID)->update([

                'TotalBudgetInUsd' => $Modules->sum('TotalBudgetInUsd'),

            ]);

        }

    }

    public function GeneralDashboard()
    {

        $Projects = DB::table('projects')->first();
        $count    = DB::table('projects')->count();

        if ($count > 0) {

            $Expenditure = DB::table('project_activity_expenditures')->where('PID', $Projects->PID)
                ->get()->sum('AmountSpentInUsd');

            $graphdata = [
                $Projects->TotalBudgetInUsd,
                $Projects->TotalGrantInUsd,
                $Projects->FundDisbursementAtPresentInUsd,
                $Expenditure,

            ];

            // Module Perforamce

            $ModuleExpenditure = DB::table('project_activity_expenditures')
                ->join('project_modules', 'project_activity_expenditures.MID', '=', 'project_modules.MID')
                ->select('project_modules.ProjectModuleName', 'project_modules.TotalBudgetInUsd', DB::raw('SUM(project_activity_expenditures.AmountSpentInUsd) as totalAmountSpent'))
                ->groupBy('ProjectModuleName')
                ->get()->toArray();

            // dd($ModuleExpenditure);

            $chart = new SystemCharts;
            $chart->labels(['Project Budget', 'Total Grunt', 'Amount Disbursed', 'Amount Spent']);

            $chart->height(200);

            $chart->dataset('Project Financial Analysis (TIMS) at present ' . date('M-Y'), 'bar', $graphdata)->backgroundcolor('#75e900');
            $chart->dataset('line graph representation ' . date('M-Y'), 'line', $graphdata)->backgroundcolor('#7e3ff2');

            $ActivityStatus = DB::table('project_ativities')
                ->select('ProgressStatus', DB::raw('count(*) as total'))
                ->groupBy('ProgressStatus')
                ->get();

            $charts = new SystemCharts;
            $charts->labels($ActivityStatus->pluck('ProgressStatus'));
            $charts->height(200);
            $charts->dataset('Project Activity Progress Status Analysis (TIMS) ' . date('M-Y'), 'bar', $ActivityStatus->pluck('total'))->backgroundcolor('red');

            $data = [
                'Title'                          => 'TIMS Project Dashboard | Project Analytics',
                'Desc'                           => 'Project financial analytics and reporting dashboard',
                'Page'                           => 'reports.Dashboard',
                'chart'                          => $chart,
                'charts'                         => $charts,
                'TotalBudgetInUsd'               => $Projects->TotalBudgetInUsd,
                'TotalGrantInUsd'                => $Projects->TotalGrantInUsd,
                'FundDisbursementAtPresentInUsd' => $Projects->FundDisbursementAtPresentInUsd,
                'Expenditure'                    => $Expenditure,
                'ModuleExpenditure'              => $ModuleExpenditure,
                'ActivityStatus'                 => $ActivityStatus,
            ];

            return view('scrn', $data);
        } else {

            return redirect()->route('MgtProjects');
        }

    }

    public function ModuleExpenditureYear()
    {

        $data = [
            'Title' => 'Select the financial year to attach analytics to | Project Expenditure Report',
            'Desc'  => 'Select finacial year',
            'Page'  => 'reports.ModExSelectYear',
        ];

        return view('scrn', $data);
    }

    public function AcceptModExYear(Request $request)
    {
        $validated = $request->validate([

            '*' => 'required',
        ]);

        $Year = $request->FinancialYear;

        return redirect()->route('ModuleFinancialAnalyis', ['Year' => $Year]);
    }

    public function ModuleFinancialAnalyis($Year)
    {

        $PerformanceByQuarter = DB::table('project_modules as pm')
            ->join('project_activity_expenditures as ae', 'pm.MID', '=', 'ae.MID')
            ->select('pm.ProjectModuleName', 'pm.TotalBudgetInUsd AS ModuleBudget', 'ae.FinancialQuarter', 'ae.FinancialYear', DB::raw('SUM(ae.AmountSpentInUsd) as SumAmount'))
        // ->where('ae.FinancialYear', $Year)
            ->groupBy('ae.FinancialQuarter', 'pm.ProjectModuleName')
            ->get();

        $PerformanceGroup = DB::table('project_modules as pm')
            ->join('project_activity_expenditures as ae', 'pm.MID', '=', 'ae.MID')
            ->select('pm.ProjectModuleName', 'ae.ExpenditureGroup', 'pm.TotalBudgetInUsd AS ModuleBudget', 'ae.FinancialQuarter', 'ae.FinancialYear', DB::raw('SUM(ae.AmountSpentInUsd) as SumAmount'))
        // ->where('ae.FinancialYear', $Year)
            ->groupBy('ae.ExpenditureGroup', 'pm.ProjectModuleName')
            ->get();

        $PerformanceGroupChart = DB::table('project_modules as pm')
            ->join('project_activity_expenditures as ae', 'pm.MID', '=', 'ae.MID')
            ->select('pm.ProjectModuleName', 'ae.ExpenditureGroup', 'pm.TotalBudgetInUsd AS ModuleBudget', 'ae.FinancialQuarter', 'ae.FinancialYear', DB::raw('SUM(ae.AmountSpentInUsd) as SumAmount'))
        // ->where('ae.FinancialYear', $Year)
            ->groupBy('ae.ExpenditureGroup', 'pm.ProjectModuleName');

        // dd($PerformanceGroup);

        // Create charts...PerformanceGroup

        $data = [
            'Title'                => ' Project Module Expenditure Report For The Financial Year ' . $Year,
            'Desc'                 => 'Module Expenditure Analysis by Year and Quarter',
            'Page'                 => 'reports.ModuleAnalysis',
            'PerformanceByQuarter' => $PerformanceByQuarter,
            'PerformanceGroup'     => $PerformanceGroup,

        ];

        return view('scrn', $data);

    }

}
