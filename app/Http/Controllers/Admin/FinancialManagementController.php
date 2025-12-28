<?php
//6-財務管理
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinancialManagementController extends Controller
{
    public function index()
    {
        return view('FinancialManagement.index');
    }


}
