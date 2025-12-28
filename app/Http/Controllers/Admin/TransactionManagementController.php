<?php

//3-事務管理
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionManagementController extends Controller
{
    public function index()
    {
        return view('transactionmanagement.index');
    }


}
