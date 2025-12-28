<?php

//2-2-8日程安排
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeetingScheduleController extends Controller
{
    public function index()
    {
        return view('organizationalmanagement.meetingschedule.index');
    }


}
