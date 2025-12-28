<?php

//5-4長期計劃
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LongTimePlan;

class LongTimePlanController extends Controller
{
   
    public function index()
    {
        $longtime = LongTimePlan::orderByDesc('updated_at')->first();
        return view('standardizedmanagement.longtimeplan.index', compact('longtime'));
    }



}
