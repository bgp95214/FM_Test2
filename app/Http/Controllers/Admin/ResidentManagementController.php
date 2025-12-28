<?php
//2-1住戶管理
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentManagementController extends Controller
{
    public function index()
    {
        $residents = Resident::with('floor')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('personnelmanagement.residentmanagement.index', compact('residents'));
    }


}
