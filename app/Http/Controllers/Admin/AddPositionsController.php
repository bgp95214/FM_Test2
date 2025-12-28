<?php

//2-2-1新增職位
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class AddPositionsController extends Controller
{
    public function index()
    {
        return view('personnelmanagement.organizationalmanagement.addpositions.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'content' => 'required|max:1000'
        ]);

        Position::create([
            'name' => $request->name,
            'content' => $request->content
        ]);

        return redirect('/positions')->with('success', '職位新增成功');
    }

    public function show($id)
    {
        $position = Position::findOrFail($id);
        return response()->json($position);
    }

    public function edit($id)
    {
        $position = Position::findOrFail($id);
        return view('personnelmanagement.organizationalmanagement.addpositions.index', compact('position'));
    }

    public function update(Request $request, $id)
    {
        $position = Position::findOrFail($id);

        $request->validate([
            'name' => 'required|max:100',
            'content' => 'required|max:1000'
        ]);

        $position->update([
            'name' => $request->name,
            'content' => $request->content
        ]);

        return redirect('/positions')->with('success', '職位更新成功');
    }

    public function destroy($id)
    {
        $position = Position::findOrFail($id);
        $position->delete();

        return redirect('/positions')->with('success', '職位刪除成功');
    }
}
