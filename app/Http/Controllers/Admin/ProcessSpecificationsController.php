<?php

//5-2流程規範
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessSpecifications;

class ProcessSpecificationsController extends Controller
{
   
    public function index()
    {
        $process = ProcessSpecifications::orderByDesc('updated_at')->first();
        return view('standardizedmanagement.processspecifications.index', compact('process'));
    }



}
