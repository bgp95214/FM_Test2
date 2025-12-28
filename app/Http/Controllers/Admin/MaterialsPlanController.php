<?php

//5-3資材計劃
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaterialsPlan;

class MaterialsPlanController extends Controller
{
    public function index()
    {
        $mat = MaterialsPlan::orderByDesc('updated_at')->first();
        return view('standardizedmanagement.materialsplan.index', compact('mat'));
    }


}
