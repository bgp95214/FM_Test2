<?php

//2-2-5例會紀錄
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::orderBy('created_at', 'desc')->get();
        return view('personnelmanagement.organizationalmanagement.meeting.index', compact('meetings'));
    }

    

}
