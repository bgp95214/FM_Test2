<?php

//5-1維護計劃
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintenancePlan;

class MaintenancePlanController extends Controller
{
    public function index()
    {
        $plan = MaintenancePlan::orderByDesc('updated_at')->first();
        return view('standardizedmanagement.maintenanceplan.index', compact('plan'));
    }


}
