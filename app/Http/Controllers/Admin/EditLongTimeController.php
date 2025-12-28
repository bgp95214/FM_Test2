<?php

//5-4-1編輯計劃
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LongTimePlan;

class EditLongTimeController extends Controller
{
    public function index()
    {
        $longtime = LongTimePlan::orderByDesc('updated_at')->first();
        return view('standardizedmanagement.longtimeplan.editlongtime.index', compact('longtime'));
        
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $longtime = null;
        if ($id && $id != 0) {
            $longtime = LongTimePlan::find($id);
        }

        if ($longtime) {
            $longtime->update($validated);
        } else {
            LongTimePlan::create($validated);
        }

        return redirect('/longtimeplan')->with('success', '長期計劃已更新');
    }


}
