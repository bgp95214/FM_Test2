<?php

//5-5住戶規章
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResidentsRegulations;

class ResidentsRegulationsController extends Controller
{
   
    public function index()
    {
        $regulations = ResidentsRegulations::orderByDesc('updated_at')->first();
        return view('standardizedmanagement.residentsregulations.index', compact('regulations'));
    }



}
