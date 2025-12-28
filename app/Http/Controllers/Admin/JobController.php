<?php

//2-3-2職稱列表
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::all();
        return view('personnelmanagement.humanmanagement.job.index', compact('jobs'));
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $jobs = Job::all();
        return view('personnelmanagement.humanmanagement.job.index', compact('job', 'jobs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'content' => 'nullable'
        ]);

        $job = Job::findOrFail($id);
        $job->update($request->only(['name', 'content']));

        return redirect('/job')->with('success', '職稱已更新');
    }

    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();
        return redirect('/job')->with('success', '職稱已刪除');
    }
}
