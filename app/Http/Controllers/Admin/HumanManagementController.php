<?php

//2-3人事管理
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Human;

class HumanManagementController extends Controller
{
    public function index()
    {
        $humans = Human::all();
        return view('personnelmanagement.humanmanagement.index', compact('humans'));
    }


}
