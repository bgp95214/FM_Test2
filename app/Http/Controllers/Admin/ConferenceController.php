<?php

//2-2-7大會紀錄
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function index()
    {
        $conferences = Conference::orderBy('created_at', 'desc')->get();
        return view('personnelmanagement.organizationalmanagement.conference.index', compact('conferences'));
    }
}
