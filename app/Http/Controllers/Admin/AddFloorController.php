<?php
//2-1-1新增樓層
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Floor;

class AddFloorController extends Controller
{
    // 顯示新增樓層頁面
    public function index()
    {
        return view('personnelmanagement.residentmanagement.addfloor.index');
    }

    // 儲存新樓層
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50'
        ]);

        Floor::create([
            'name' => $request->name
        ]);

        return redirect('/floors')->with('success', '樓層已成功新增！');
    }

    // 顯示單筆樓層
    public function show($id)
    {
        $floor = Floor::findOrFail($id);
        return view('personnelmanagement.residentmanagement.addfloor.show', compact('floor'));
    }

    // 顯示編輯頁面
    public function edit($id)
    {
        $floor = Floor::findOrFail($id);
        return view('personnelmanagement.residentmanagement.addfloor.index', compact('floor'));
    }

    // 更新樓層
    public function update(Request $request, $id)
    {
        $floor = Floor::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50'
        ]);

        $floor->update([
            'name' => $request->name
        ]);

        return redirect('/floors')->with('success', '樓層已成功更新！');
    }

    // 刪除樓層
    public function destroy($id)
    {
        $floor = Floor::findOrFail($id);
        $floor->delete();

        return redirect('/floors')->with('success', '樓層已成功刪除！');
    }
}
