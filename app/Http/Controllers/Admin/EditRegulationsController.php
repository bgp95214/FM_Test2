<?php

//5-5-1編輯規章
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResidentsRegulations;

class EditRegulationsController extends Controller
{
    public function index()
    {
        $regulations = ResidentsRegulations::orderByDesc('updated_at')->first();
        return view('standardizedmanagement.residentsregulations.editregulations.index', compact('regulations'));
        
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $regulations = null;
        if ($id && $id != 0) {
            $regulations = ResidentsRegulations::find($id);
        }

        if ($regulations) {
            $regulations->update($validated);
        } else {
            ResidentsRegulations::create($validated);
        }

        return redirect('/residentsregulations')->with('success', '住戶規章已更新');
    }


}
