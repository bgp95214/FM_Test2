<?php

//1-社區資訊
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommunityInformationController extends Controller
{
    public function index()
    {
        return view('communityinformation.index');
    }


}
