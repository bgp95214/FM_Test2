<?php

//4-資產管理
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssetManagementController extends Controller
{
    public function index()
    {
        return view('assetmanagement.index');
    }


}
