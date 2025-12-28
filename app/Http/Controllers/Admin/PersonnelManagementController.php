<?php

//2-人員管理
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonnelManagementController extends Controller
{
    public function index()
    {
        return view('personnelmanagement.index');
    }


}
