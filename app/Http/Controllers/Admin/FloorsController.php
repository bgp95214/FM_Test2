<?php

//2-1-2樓層清單
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorsController extends Controller
{
    public function index()
    {
        $floors = Floor::orderBy('created_at', 'desc')->paginate(10);
        return view('personnelmanagement.residentmanagement.floors.index', compact('floors'));
    }
}
