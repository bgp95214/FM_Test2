<?php

//2-2組織管理
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\PositionAllocation;
use Illuminate\Http\Request;

class OrganizationalManagementController extends Controller
{
    public function index()
    {
        $positions = Position::orderBy('created_at', 'desc')->get();
        $allocations = PositionAllocation::with(['resident.floor'])->get()->keyBy('position_id');

        return view('personnelmanagement.organizationalmanagement.index', compact('positions', 'allocations'));
    }


}
