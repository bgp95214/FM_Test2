<?php
//4-1-1新增分類
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assets;

class AddAssetsController extends Controller
{
    // 顯示新增樓層頁面
    public function index()
    {
        return view('assetmanagement.communityassets.addassets.index');
    }

    // 儲存新分類
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50'
        ]);

        Assets::create([
            'name' => $request->name
        ]);

        return redirect('/assetslist')->with('success', '分類已成功新增！');
    }

    // 顯示單筆分類
    public function show($id)
    {
        $assets = Assets::findOrFail($id);
        return view('assetmanagement.communityassets.addassets.show', compact('assets'));
    }

    // 顯示編輯分類
    public function edit($id)
    {
        $assets = Assets::findOrFail($id);
        return view('assetmanagement.communityassets.addassets.index', compact('assets'));
    }

    // 更新分類
    public function update(Request $request, $id)
    {
        $assets = Assets::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50'
        ]);

        $assets->update([
            'name' => $request->name
        ]);

        return redirect('/assetslist')->with('success', '分類已成功更新！');
    }

    // 刪除分類
    public function destroy($id)
    {
        $assets = Assets::findOrFail($id);
        $assets->delete();

        return redirect('/assetslist')->with('success', '分類已成功刪除！');
    }
}
