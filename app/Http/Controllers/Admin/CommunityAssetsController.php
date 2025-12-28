<?php

//4-1社區資產
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class CommunityAssetsController extends Controller
{
    public function index()
    {
        $devices = Device::with(['assets', 'vendor'])->get();
        return view('assetmanagement.communityassets.index', compact('devices'));
    }


}
