<?php

//2-2-4例會填寫
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WritemeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::orderBy('created_at', 'desc')->get();
        return view('personnelmanagement.organizationalmanagement.writemeeting.index', compact('meetings'));
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
            $request->file('photo')->move(public_path('uploads/meeting'), $filename);
            $photoPath = 'uploads/meeting/' . $filename;
        }

        Meeting::create([
            'title' => $request->title,
            'content' => $request->content,
            'photo' => $photoPath,
        ]);

        return redirect('/writemeeting')->with('success', '例會資料已提交');
    }

    public function edit($id)
    {
        $meeting = Meeting::findOrFail($id);
        $meetings = Meeting::orderBy('created_at', 'desc')->get();
        return view('personnelmanagement.organizationalmanagement.writemeeting.index', compact('meeting', 'meetings'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:150',
            'content' => 'required',
            'photo' => 'nullable|image|max:2048'
        ]);

        $meeting = Meeting::findOrFail($id);

        // 處理新上傳的照片
        if ($request->hasFile('photo')) {
            // 刪除舊照片
            if ($meeting->photo && file_exists(public_path($meeting->photo))) {
                unlink(public_path($meeting->photo));
            }
            
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->move(public_path('uploads/meeting'), $filename);
            $meeting->photo = 'uploads/meeting/' . $filename;
        }

        $meeting->title = $request->title;
        $meeting->content = $request->content;
        $meeting->save();

        return redirect('/writemeeting')->with('success', '例會資料已更新');
    }

    public function destroy($id)
    {
        $meeting = Meeting::findOrFail($id);

        if ($meeting->photo && file_exists(public_path($meeting->photo))) {
            unlink(public_path($meeting->photo));
        }

        $meeting->delete();

        return redirect('/writemeeting')->with('success', '例會資料已刪除');
    }


}
