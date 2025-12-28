<?php

//4-1-2分類列表
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use Illuminate\Http\Request;

class AssetsListController extends Controller
{
    public function index()
    {
        $assets = Assets::orderBy('created_at', 'desc')->paginate(10);
        return view('assetmanagement.communityassets.assetslist.index', compact('assets'));
    }
}
