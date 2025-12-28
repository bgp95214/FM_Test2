<?php

//2-4廠商管理
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorManagementController extends Controller
{
    public function index()
    {
            $vendors = Vendor::all();
            return view('personnelmanagement.vendormanagement.index', compact('vendors'));
    }


}
