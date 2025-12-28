<?php

//2-2-3職位分配
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\Resident;
use App\Models\PositionAllocation;
use Illuminate\Http\Request;

class AllocationController extends Controller
{
    public function index()
    {
        $positions = Position::all();
        $residents = Resident::with('floor')->get();
        $allocations = PositionAllocation::with(['position', 'resident'])->get();
        
        return view('personnelmanagement.organizationalmanagement.allocation.index', compact('positions', 'residents', 'allocations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'position_id' => 'required|exists:positions,id',
            'resident_id' => 'required|exists:residents,id|unique:position_allocations,resident_id'
        ], [
            'resident_id.unique' => '該住戶已被分配職位，請先取消原職位分配'
        ]);

        PositionAllocation::create([
            'position_id' => $request->position_id,
            'resident_id' => $request->resident_id
        ]);

        return redirect('/allocation')->with('success', '職位分配成功');
    }

    public function destroy($id)
    {
        $allocation = PositionAllocation::findOrFail($id);
        $allocation->delete();

        return redirect('/allocation')->with('success', '職位分配取消成功');
    }
}
