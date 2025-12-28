<?php

//3-6-2新增公告
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    // 顯示新增/編輯公告頁面
    public function index()
    {
        return view('transactionmanagement.announcementmanagement.announcement.index');
    }

    // 顯示編輯頁面
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('transactionmanagement.announcementmanagement.announcement.index', compact('announcement'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'attachment' => 'nullable|file|max:10240' // 最大 10MB
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        // 處理附件上傳
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['attachment'] = 'uploads/' . $filename;
        }

        Announcement::create($data);

        return redirect('/announcementmanagement')->with('success', '公告已成功發布！');
    }

    // 顯示單筆公告
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('transactionmanagement.announcementmanagement.announcement.show', compact('announcement'));
    }

    // 更新公告
    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'attachment' => 'nullable|file|max:10240'
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        // 處理附件上傳
        if ($request->hasFile('attachment')) {
            // 刪除舊檔案
            if ($announcement->attachment && file_exists(public_path($announcement->attachment))) {
                unlink(public_path($announcement->attachment));
            }
            
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['attachment'] = 'uploads/' . $filename;
        }

        $announcement->update($data);

        return redirect('/announcementmanagement')->with('success', '公告已成功更新！');
    }

    // 刪除公告
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        // 刪除附件
        if ($announcement->attachment && file_exists(public_path($announcement->attachment))) {
            unlink(public_path($announcement->attachment));
        }

        $announcement->delete();

        return redirect('/announcementmanagement')->with('success', '公告已成功刪除！');
    }
}
