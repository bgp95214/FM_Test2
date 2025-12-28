<?php

//4-2公務車管理
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarManagementController extends Controller
{
    public function index()
    {
        $cars = Car::with('vendor')->orderBy('license_plate')->get();
        return view('assetmanagement.carmanagement.index', compact('cars'));
    }


}
