<?php

//2-3-1新增職稱
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class AddJobController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'desc')->get();
        return view('personnelmanagement.humanmanagement.addjob.index', compact('jobs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'content' => 'nullable'
        ]);

        Job::create([
            'name' => $request->name,
            'content' => $request->content,
        ]);

        return redirect('/job')->with('success', '職位已新增');
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $jobs = Job::orderBy('created_at', 'desc')->get();
        return view('personnelmanagement.humanmanagement.addjob.index', compact('job', 'jobs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'content' => 'nullable'
        ]);

        $job = Job::findOrFail($id);
        $job->name = $request->name;
        $job->content = $request->content;
        $job->save();

        return redirect('/job')->with('success', '職位已更新');
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return redirect('/job')->with('success', '職位已刪除');
    }
}
