<?php
//2-1-3新增住戶
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AddResidentsController extends Controller
{
    public function index()
    {
        $floors = Floor::all();
        return view('personnelmanagement.residentmanagement.addresidents.index', compact('floors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'floor_id' => 'required|exists:floors,id',
            'door_number' => 'required|max:50',
            'contact_phone' => 'required|max:20',
            'account' => 'required|unique:residents,account|max:50',
            'password' => 'required|min:6'
        ]);

        Resident::create([
            'name' => $request->name,
            'floor_id' => $request->floor_id,
            'door_number' => $request->door_number,
            'contact_phone' => $request->contact_phone,
            'account' => $request->account,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/residentmanagement')->with('success', '住戶新增成功');
    }

    public function show($id)
    {
        $resident = Resident::with('floor')->findOrFail($id);
        return response()->json($resident);
    }

    public function edit($id)
    {
        $resident = Resident::findOrFail($id);
        $floors = Floor::all();
        return view('personnelmanagement.residentmanagement.addresidents.index', compact('resident', 'floors'));
    }

    public function update(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);

        $request->validate([
            'name' => 'required|max:100',
            'floor_id' => 'required|exists:floors,id',
            'door_number' => 'required|max:50',
            'contact_phone' => 'required|max:20',
            'account' => 'required|max:50|unique:residents,account,' . $id,
            'password' => 'nullable|min:6'
        ]);

        $data = [
            'name' => $request->name,
            'floor_id' => $request->floor_id,
            'door_number' => $request->door_number,
            'contact_phone' => $request->contact_phone,
            'account' => $request->account,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $resident->update($data);

        return redirect('/residentmanagement')->with('success', '住戶更新成功');
    }

    public function destroy($id)
    {
        $resident = Resident::findOrFail($id);
        $resident->delete();

        return redirect('/residentmanagement')->with('success', '住戶刪除成功');
    }
}
