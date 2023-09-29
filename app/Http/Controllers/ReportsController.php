<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\FormEngine;

class ReportsController extends Controller
{

    public function TechSelectActivityProject()
    {

        $Projects = DB::table('projects')->get();

        $data = [
            'Title'    => 'Project Selection | Project Activity Settings',
            'Desc'     => 'Select project for activity progress tracking',
            'Page'     => 'TechRep.SelectProject',
            'Projects' => $Projects,
        ];

        return view('scrn', $data);

    }
    public function TechAcceptProjectActivities(Request $request)
    {

        $validated = $request->validate([
            '*' => 'required',
        ]);

        $PID = $request->PID;

        return redirect()->route('TechActivityProjectModule', ['PID' => $PID]);

    }

    public function TechActivityProjectModule($PID)
    {
        $Modules = DB::table('project_modules')->where('PID', $PID)->get();

        $data = [
            'Title'   => 'Module Selection | Project Activity Settings',
            'Desc'    => 'Select module to attach activities to',
            'Page'    => 'TechRep.SelectModule',
            'Modules' => $Modules,
        ];

        return view('scrn', $data);
    }

    public function TechAcceptActivityModule(Request $request)
    {

        $validated = $request->validate([

            '*' => 'required',
        ]);

        $Modules = DB::table('project_modules')->where('MID', $request->MID)->first();

        $MID = $Modules->MID;
        $PID = $Modules->PID;

        return redirect()->route('TechMgtProjectActivities', ['PID' => $PID, 'MID' => $MID]);

    }

    public function TechMgtProjectActivities($PID, $MID)
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
            'Page'        => 'TechRep.TechReport',
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

}
