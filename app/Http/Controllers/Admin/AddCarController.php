<?php

//4-2-1新增公務車
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AddCarController extends Controller
{
    public function index()
    {
        $vendors = Vendor::orderBy('name')->get();
        return view('assetmanagement.carmanagement.addcar.index', compact('vendors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required|string|max:50|unique:car,license_plate',
            'brand' => 'required|string|max:100',
            'purchase_date' => 'required|date',
            'maintenance_method' => 'required|string',
            'status' => 'required|string|in:normal,maintenance',
            'vendor_id' => 'nullable|exists:vendors,id',
        ]);

        Car::create($validated);

        return redirect('/carmanagement')->with('success', '公務車新增成功');
    }

    public function show($id)
    {
        $car = Car::findOrFail($id);
        $vendors = Vendor::orderBy('name')->get();

        return view('assetmanagement.carmanagement.addcar.show', compact('car', 'vendors'));
    }

    public function edit($id)
    {
        $car = Car::findOrFail($id);
        $vendors = Vendor::orderBy('name')->get();

        return view('assetmanagement.carmanagement.addcar.index', compact('car', 'vendors'));
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $validated = $request->validate([
            'license_plate' => 'required|string|max:50|unique:car,license_plate,' . $car->id,
            'brand' => 'required|string|max:100',
            'purchase_date' => 'required|date',
            'maintenance_method' => 'required|string',
            'status' => 'required|string|in:normal,maintenance',
            'vendor_id' => 'nullable|exists:vendors,id',
        ]);

        $car->update($validated);

        return redirect('/carmanagement')->with('success', '公務車更新成功');
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return redirect('/carmanagement')->with('success', '公務車刪除成功');
    }

}
