<?php

//5-2-1編輯規範
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessSpecifications;

class EditProcessController extends Controller
{
    public function index()
    {
        $process = ProcessSpecifications::orderByDesc('updated_at')->first();
        return view('standardizedmanagement.processspecifications.editprocesss.index', compact('process'));
        
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $process = null;
        if ($id && $id != 0) {
            $process = ProcessSpecifications::find($id);
        }

        if ($process) {
            $process->update($validated);
        } else {
            ProcessSpecifications::create($validated);
        }

        return redirect('/processspecifications')->with('success', '流程規範已更新');
    }


}
