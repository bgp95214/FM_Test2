<?php
//入口
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class EntranceController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->limit(5)->get();
        return view('Entrance.index', compact('announcements'));
    }
}
