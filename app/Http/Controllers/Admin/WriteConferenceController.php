<?php

//2-2-6大會填寫
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use Illuminate\Http\Request;

class WriteConferenceController extends Controller
{
    public function index()
    {
        $conferences = Conference::orderBy('created_at', 'desc')->get();
        return view('personnelmanagement.organizationalmanagement.writeconference.index', compact('conferences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:150',
            'content' => 'required',
            'photo' => 'nullable|image|max:2048'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('uploads/conference'), $filename);
            $photoPath = 'uploads/conference/' . $filename;
        }

        Conference::create([
            'title' => $request->title,
            'content' => $request->content,
            'photo' => $photoPath,
        ]);

        return redirect('/conference')->with('success', '大會資料已提交');
    }

    public function edit($id)
    {
        $conference = Conference::findOrFail($id);
        $conferences = Conference::orderBy('created_at', 'desc')->get();
        return view('personnelmanagement.organizationalmanagement.writeconference.index', compact('conference', 'conferences'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:150',
            'content' => 'required',
            'photo' => 'nullable|image|max:2048'
        ]);

        $conference = Conference::findOrFail($id);

        if ($request->hasFile('photo')) {
            if ($conference->photo && file_exists(public_path($conference->photo))) {
                unlink(public_path($conference->photo));
            }
            
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('uploads/conference'), $filename);
            $conference->photo = 'uploads/conference/' . $filename;
        }

        $conference->title = $request->title;
        $conference->content = $request->content;
        $conference->save();

        return redirect('/conference')->with('success', '大會資料已更新');
    }

    public function destroy($id)
    {
        $conference = Conference::findOrFail($id);

        if ($conference->photo && file_exists(public_path($conference->photo))) {
            unlink(public_path($conference->photo));
        }

        $conference->delete();

        return redirect('/conference')->with('success', '大會資料已刪除');
    }
}
