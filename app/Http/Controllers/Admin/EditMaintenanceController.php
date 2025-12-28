<?php

//5-1-1 編輯計劃
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintenancePlan;

class EditMaintenanceController extends Controller
{
    public function index()
    {
        $plan = MaintenancePlan::orderByDesc('updated_at')->first();
        return view('standardizedmanagement.maintenanceplan.editmaintenance.index', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $plan = null;
        if ($id && $id != 0) {
            $plan = MaintenancePlan::find($id);
        }

        if ($plan) {
            $plan->update($validated);
        } else {
            MaintenancePlan::create($validated);
        }

        return redirect('/maintenanceplan')->with('success', '維護計劃已更新');
    }
}
