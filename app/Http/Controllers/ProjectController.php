<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\FormEngine;

class ProjectController extends Controller
{

    public function MgtProjects()
    {

        $Form = new FormEngine;
        $rem  = ['created_at', 'updated_at', 'id', 'VarianceInUsdAtPresent', 'FundsAvailableAtPresentInUsd', 'AvailableFundInUsd', 'TotalBudgetInUsd', 'ProjectExpenditureAtPresentInUsd', 'PID'];

        $Projects = DB::table('projects')->get();

        $data = [
            'Title'    => 'ECSA-HC Project Management System',
            'Desc'     => 'Virtual Office Dashboard',
            'Page'     => 'projects.MgtProjects',
            'Projects' => $Projects,
            'rem'      => $rem,
            'editor'   => 'editor',
            'Form'     => $Form->Form('projects'),

        ];

        return view('scrn', $data);
    }

    public function ModuleSelectProject()
    {

        $Projects = DB::table('projects')->get();

        $data = [
            'Title'    => 'Project Selection | Project Module Settings',
            'Desc'     => 'Select project to attach module to',
            'Page'     => 'modules.SelectProject',
            'Projects' => $Projects,
        ];

        return view('scrn', $data);

    }

    public function AcceptProjectModule(Request $request)
    {

        $validated = $request->validate([
            '*' => 'required',
        ]);

        $PID = $request->PID;

        return redirect()->route('MgtProjectModules', ['PID' => $PID]);

    }

    public function MgtProjectModules($PID)
    {

        $Form = new FormEngine;
        $rem  = ['created_at', 'updated_at', 'id', 'PID', 'MID', 'BudgetAmountSpentAtPresent', 'BudgetAmountAvailable', ''];

        $Projects = DB::table('projects')->where('PID', $PID)->first();
        $Modules  = DB::table('project_modules')->where('PID', $PID)->get();

        $data = [
            'Title'       => $Projects->ProjectName . '| Manage modules',
            'Desc'        => 'Project module management and data settings',
            'Page'        => 'modules.MgtModules',
            'Modules'     => $Modules,
            'rem'         => $rem,
            'editor'      => '$rem',
            'PID'         => $Projects->PID,
            'ProjectName' => $Projects->ProjectName,
            'Form'        => $Form->Form('project_modules'),

        ];

        return view('scrn', $data);
    }

    public function SelectActivityProject()
    {

        $Projects = DB::table('projects')->get();

        $data = [
            'Title'    => 'Project Selection | Project Activity Settings',
            'Desc'     => 'Select project to attach activities to',
            'Page'     => 'activities.SelectProject',
            'Projects' => $Projects,
        ];

        return view('scrn', $data);

    }

    public function AcceptProjectActivities(Request $request)
    {

        $validated = $request->validate([
            '*' => 'required',
        ]);

        $PID = $request->PID;

        return redirect()->route('ActivityProjectModule', ['PID' => $PID]);

    }

    public function ActivityProjectModule($PID)
    {
        $Modules = DB::table('project_modules')->where('PID', $PID)->get();

        $data = [
            'Title'   => 'Module Selection | Project Activity Settings',
            'Desc'    => 'Select module to attach activities to',
            'Page'    => 'activities.SelectModule',
            'Modules' => $Modules,
        ];

        return view('scrn', $data);
    }

    public function AcceptActivityModule(Request $request)
    {

        $validated = $request->validate([

            '*' => 'required',
        ]);

        $Modules = DB::table('project_modules')->where('MID', $request->MID)->first();

        $MID = $Modules->MID;
        $PID = $Modules->PID;

        return redirect()->route('MgtProjectActivities', ['PID' => $PID, 'MID' => $MID]);

    }

    public function MgtProjectActivities($PID, $MID)
    {

        $Form = new FormEngine;
        $rem  = ['created_at', 'updated_at', 'Comments', 'id', 'FinancialQuater', 'PID', 'MID', 'AID', 'ProgressStatus', 'BudgetAmountSpentAtPresent', 'BudgetAmountAvailable', 'FinancialYear'];

        $Projects = DB::table('projects')->where('PID', $PID)->first();

        $Activities = DB::table('project_ativities AS A')
            ->join('project_modules as M', 'M.MID', 'A.MID')
            ->select('A.*', 'M.ProjectModuleName')
            ->where('M.PID', $PID)
            ->where('M.MID', $MID)
            ->get();

        $Modules    = DB::table('project_modules')->where('MID', $MID)->first();
        $ModuleName = $Modules->ProjectModuleName;

        $data = [
            'Title'       => $Projects->ProjectName . '| Manage Activities attached to the module ' . $ModuleName,
            'Desc'        => 'Project activity management and data settings',
            'Page'        => 'activities.MgtActivities',
            'Activities'  => $Activities,
            'Modules'     => $Modules,
            'rem'         => $rem,
            'editor'      => '$rem',
            'PID'         => $Projects->PID,
            'MID'         => $Modules->MID,
            'ProjectName' => $Projects->ProjectName,
            'ModuleName'  => $ModuleName,
            'Form'        => $Form->Form('project_ativities'),

        ];

        return view('scrn', $data);
    }

    public function ExpenditureSelectProject()
    {

        $Projects = DB::table('projects')->get();

        $data = [
            'Title'    => 'Project Selection | Project Expenditure Settings',
            'Desc'     => 'Select project to attach expenditure to',
            'Page'     => 'expenditure.SelectProject',
            'Projects' => $Projects,
        ];

        return view('scrn', $data);

    }

    public function ExpenditureSelectModule(Request $request)
    {
        $Modules = DB::table('project_modules')->where('PID', $request->PID)->get();

        $data = [
            'Title'   => 'Module Selection | Project Expenditure Settings',
            'Desc'    => 'Select module to attach expenditure to',
            'Page'    => 'expenditure.SelectModule',
            'Modules' => $Modules,
        ];

        return view('scrn', $data);
    }

    public function AcceptActivityModuleActivity(Request $request)
    {
        $validated = $request->validate([

            '*' => 'required',
        ]);

        $MID = $request->MID;

        return redirect()->route('MgtActivityExpenditure', ['MID' => $MID]);
    }

    public function MgtActivityExpenditure($MID)
    {
        $Expenditures = DB::table('project_activity_expenditures AS E')
            ->join('projects AS P', 'P.PID', 'E.PID')
            ->join('project_modules AS M', 'M.MID', 'E.MID')
            ->join('project_ativities AS A', 'A.AID', 'E.AID')
            ->where('E.MID', $MID)
            ->select('E.*', 'P.ProjectName', 'M.ProjectModuleName', 'A.ActivityName')
            ->get();

        $Modules = DB::table('project_modules')->where('MID', $MID)->first();
        // $A       = DB::table('project_ativities')->where('MID', $MID)->first();
        $Project = DB::table('projects')->where('PID', $Modules->PID)->first();

        // $AID         = $A->AID; // useless
        $PID         = $Project->PID;
        $ProjectName = $Project->ProjectName;
        $ModuleName  = $Modules->ProjectModuleName;

        $Activities = DB::table('project_ativities')->where('MID', $MID)->get();

        $ExpednditureGroups = DB::table('expenditure_groups')->get();

        $Form = new FormEngine;

        $rem = ['created_at', 'FinancialYear', 'FinancialQuarter', 'ExpenditureGroup', 'updated_at', 'id', 'PID', 'AID', 'MID', 'EID', 'ExpednditureGroup'];

        $data = [
            'Title'              => 'Project Settings | Create and Manage Project Expenditure',
            'Desc'               => 'Project Activity Expenditure  Management',
            'Page'               => 'expenditure.MgtExpenditure',
            'Expenditures'       => $Expenditures,
            'Activities'         => $Activities,
            'ProjectName'        => $ProjectName,
            'ModuleName'         => $ModuleName,
            'ExpednditureGroups' => $ExpednditureGroups,
            'MID'                => $MID,
            'PID'                => $PID,
            'rem'                => $rem,
            'editor'             => 'editor',
            'Form'               => $Form->Form('project_activity_expenditures'),

        ];

        return view('scrn', $data);

    }

    public function MgtExpenditureCategories()
    {

        $ExpednditureGroups = DB::table('expenditure_groups')->get();

        $Form = new FormEngine;

        $rem = ['created_at', 'updated_at', 'id'];

        $data = [
            'Title'              => 'Project Settings | Create and Manage Expenditure Group',
            'Desc'               => 'Expenditure Group Management',
            'Page'               => 'expenditure.ExpenditureGroups',
            'ExpednditureGroups' => $ExpednditureGroups,
            'rem'                => $rem,
            'editor'             => 'editor',
            'Form'               => $Form->Form('expenditure_groups'),

        ];

        return view('scrn', $data);

    }

}
