<?php

//2-3-3新增人員
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Human;
use App\Models\Job;

class AddHumanController extends Controller
{
    public function index()
    {
        $jobs = Job::all();
        return view('personnelmanagement.humanmanagement.addhuman.index', compact('jobs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'job_title' => 'required|string|max:100',
            'hire_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
        ]);

        Human::create($validated);

        return redirect('/humanmanagement')->with('success', '人員新增成功！');
    }

    public function edit($id)
    {
        $human = Human::findOrFail($id);
        $jobs = Job::all();
        return view('personnelmanagement.humanmanagement.addhuman.edit', compact('human', 'jobs'));
    }

    public function update(Request $request, $id)
    {
        $human = Human::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'job_title' => 'required|string|max:100',
            'hire_date' => 'required|date',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:100',
        ]);

        $human->update($validated);

        return redirect('/humanmanagement')->with('success', '人員資料已更新！');
    }

    public function destroy($id)
    {
        $human = Human::findOrFail($id);
        $human->delete();

        return redirect('/humanmanagement')->with('success', '人員已刪除！');
    }
}
