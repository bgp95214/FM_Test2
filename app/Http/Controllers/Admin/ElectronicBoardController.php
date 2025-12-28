<?php

//3-6-1電子公告
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ElectronicBoardController extends Controller
{
    public function index()
    {
        return view('transactionmanagement.announcementmanagement.electronicboard.index');
    }

}
