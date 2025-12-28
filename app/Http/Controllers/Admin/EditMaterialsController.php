<?php

//5-3-1編輯規範
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialsPlan;

class EditMaterialsController extends Controller
{
    public function index()
    {
        $mat = MaterialsPlan::orderByDesc('updated_at')->first();
        return view('standardizedmanagement.materialsplan.editmaterials.index', compact('mat'));
        
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $mat = null;
        if ($id && $id != 0) {
            $mat = MaterialsPlan::find($id);
        }

        if ($mat) {
            $mat->update($validated);
        } else {
            MaterialsPlan::create($validated);
        }

        return redirect('/materialsplan')->with('success', '資材計劃已更新');
    }


}
