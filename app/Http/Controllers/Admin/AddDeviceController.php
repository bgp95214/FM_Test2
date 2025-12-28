<?php

//4-1-新增設備
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Assets;
use App\Models\Device;
use Illuminate\Http\Request;

class AddDeviceController extends Controller
{
    public function index()
    {
        $vendors = Vendor::orderBy('name')->get();
        $assets  = Assets::orderBy('name')->get();

        return view('assetmanagement.communityassets.adddevice.index', compact('vendors', 'assets'));
        
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'content' => 'nullable|string',
            'purchase_date' => 'required|date',
            'warranty_end' => 'required|numeric|min:0',
            'status' => 'required|string|in:normal,maintenance',
            'vendor_id' => 'nullable|exists:vendors,id',
            'asset_id' => 'required|exists:assets,id',
        ]);

        Device::create($validated);

        return redirect('/communityassets')->with('success', '設備新增成功');
    }

    public function show($id)
    {
        $device = Device::findOrFail($id);
        $vendors = Vendor::orderBy('name')->get();
        $assets = Assets::orderBy('name')->get();

        return view('assetmanagement.communityassets.adddevice.show', compact('device', 'vendors', 'assets'));
    }

    public function edit($id)
    {
        $device = Device::findOrFail($id);
        $vendors = Vendor::orderBy('name')->get();
        $assets = Assets::orderBy('name')->get();

        return view('assetmanagement.communityassets.adddevice.index', compact('device', 'vendors', 'assets'));
    }

    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'content' => 'nullable|string',
            'purchase_date' => 'required|date',
            'warranty_end' => 'required|numeric|min:0',
            'status' => 'required|string|in:normal,maintenance',
            'vendor_id' => 'nullable|exists:vendors,id',
            'asset_id' => 'required|exists:assets,id',
        ]);

        $device->update($validated);

        return redirect('/communityassets')->with('success', '設備更新成功');
    }

    public function destroy($id)
    {
        $device = Device::findOrFail($id);
        $device->delete();

        return redirect('/communityassets')->with('success', '設備刪除成功');
    }
}
