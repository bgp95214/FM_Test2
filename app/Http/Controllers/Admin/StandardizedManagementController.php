<?php

//5-規範管理
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StandardizedManagementController extends Controller
{
    public function index()
    {
        return view('standardizedmanagement.index');
    }


}
