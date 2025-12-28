<?php

//2-4-1新增廠商
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;

class AddVendorController extends Controller
{
    public function index()
    {
        return view('personnelmanagement.vendormanagement.addvendor.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'contact_person' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'service_item' => 'required|string|max:255',
            'email' => 'required|email|max:100',
        ]);

        Vendor::create($validated);

        return redirect('/vendormanagement')->with('success', '廠商新增成功！');
    }


    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('personnelmanagement.vendormanagement.addvendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'contact_person' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'service_item' => 'required|string|max:255',
            'email' => 'required|email|max:100',
        ]);

        $vendor->update($validated);

        return redirect('/vendormanagement')->with('success', '廠商資料已更新！');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return redirect('/vendormanagement')->with('success', '廠商已刪除！');
    }
}