<?php

//2-2-2職位清單
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionsController extends Controller
{
    public function index()
    {
        $positions = Position::orderBy('created_at', 'desc')->paginate(10);
        return view('personnelmanagement.organizationalmanagement.positions.index', compact('positions'));
    }
}
