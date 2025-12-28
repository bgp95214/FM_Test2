<?php

use Illuminate\Support\Facades\Route;


//入口
Route::get('/entrance', [App\Http\Controllers\Admin\EntranceController::class, 'index']);

//1-社區資訊
Route::get('/communityinformation', [App\Http\Controllers\Admin\CommunityInformationController::class, 'index']);
    //1日常日程
    Route::get('/dailyschedule', [App\Http\Controllers\Admin\DailyScheduleController::class, 'index']);
    //2維修清單
    Route::get('/repairlist', [App\Http\Controllers\Admin\RepairListController::class, 'index']);
    //3住戶資料
    Route::get('/residentdata', [App\Http\Controllers\Admin\ResidentDataController::class, 'index']);
    //4資產資料
    Route::get('/assetinformation', [App\Http\Controllers\Admin\AssetInformationController::class, 'index']);
    //5公設預約
    Route::get('/publicreservation', [App\Http\Controllers\Admin\PublicReservationController::class, 'index']);
    //6公務車預約表
    Route::get('/carreservation', [App\Http\Controllers\Admin\CarReservationController::class, 'index']);
    //7公告事項
    Route::get('/announcement', [App\Http\Controllers\Admin\AnnouncementController::class, 'index']);


//2-人員管理
Route::get('/personnelmanagement', [App\Http\Controllers\Admin\PersonnelManagementController::class, 'index']);
    //2-1住戶管理
    Route::get('/residentmanagement', [App\Http\Controllers\Admin\ResidentManagementController::class, 'index']);
        //2-1-1新增樓層
        Route::get('/addfloor', [App\Http\Controllers\Admin\AddFloorController::class, 'index']);
        Route::resource('addfloor', App\Http\Controllers\Admin\AddFloorController::class)->only(['store', 'show', 'edit', 'update', 'destroy']);
        //2-1-2樓層清單
        Route::get('/floors', [App\Http\Controllers\Admin\FloorsController::class, 'index']);
        //2-1-3新增住戶
        Route::get('/addresidents', [App\Http\Controllers\Admin\AddResidentsController::class, 'index']);
        Route::resource('addresidents', App\Http\Controllers\Admin\AddResidentsController::class)->only(['store', 'show', 'edit', 'update', 'destroy']);
        
    //2-2組織管理
    Route::get('/organizationalmanagement', [App\Http\Controllers\Admin\OrganizationalManagementController::class, 'index']);
        //2-2-1新增職位
        Route::get('/addpositions', [App\Http\Controllers\Admin\AddPositionsController::class, 'index']);
        Route::resource('addpositions', App\Http\Controllers\Admin\AddPositionsController::class)->only(['store', 'show', 'edit', 'update', 'destroy']);
        //2-2-2職位清單
        Route::get('/positions', [App\Http\Controllers\Admin\PositionsController::class, 'index']);
        //2-2-3職位分配
        Route::get('/allocation', [App\Http\Controllers\Admin\AllocationController::class, 'index']);
        Route::resource('allocation', App\Http\Controllers\Admin\AllocationController::class)->only(['store', 'destroy']);
        //2-2-4例會填寫
        Route::get('/writemeeting', [App\Http\Controllers\Admin\WritemeetingController::class, 'index']);
        Route::resource('writemeeting', App\Http\Controllers\Admin\WritemeetingController::class)->only(['store', 'show', 'edit', 'update', 'destroy']);
        //2-2-5例會紀錄
        Route::get('/meeting', [App\Http\Controllers\Admin\MeetingController::class, 'index']);
        //2-2-6大會填寫
        Route::get('/writeconference', [App\Http\Controllers\Admin\WriteConferenceController::class, 'index']);
        Route::resource('writeconference', App\Http\Controllers\Admin\WriteConferenceController::class)->only(['store', 'show', 'edit', 'update', 'destroy']);
        //2-2-7大會紀錄
        Route::get('/conference', [App\Http\Controllers\Admin\ConferenceController::class, 'index']);
        //2-2-8日程安排
        Route::get('/meetingschedule', [App\Http\Controllers\Admin\MeetingScheduleController::class, 'index']);

    //2-3人事管理
    Route::get('/humanmanagement', [App\Http\Controllers\Admin\HumanManagementController::class, 'index']);
        //2-3-1新增職稱
        Route::get('/addjob', [App\Http\Controllers\Admin\AddJobController::class, 'index']);
        Route::resource('addjob', App\Http\Controllers\Admin\AddJobController::class)->only(['store', 'show', 'edit', 'update', 'destroy']);
        //2-3-2職稱列表     
        Route::get('/job', [App\Http\Controllers\Admin\JobController::class, 'index']);
        //2-3-3新增人員
        Route::get('/addhuman', [App\Http\Controllers\Admin\AddHumanController::class, 'index']);
        Route::resource('addhuman', App\Http\Controllers\Admin\AddHumanController::class)->only(['store', 'show', 'edit', 'update', 'destroy']);
        
    //2-4廠商管理
    Route::get('/vendormanagement', [App\Http\Controllers\Admin\VendorManagementController::class, 'index']);
        //2-4-1新增廠商
        Route::get('/addvendor', [App\Http\Controllers\Admin\AddVendorController::class, 'index']);
        Route::resource('addvendor', App\Http\Controllers\Admin\AddVendorController::class)->only(['store', 'show', 'edit', 'update', 'destroy']);


//3-事務管理
Route::get('/transactionmanagement', [App\Http\Controllers\Admin\TransactionManagementController::class, 'index']);
    //3-1包裹管理
    Route::get('/packagemanagement', [App\Http\Controllers\Admin\PackageManagementController::class, 'index']);
    //3-2報修管理
    Route::get('/repairmanagement', [App\Http\Controllers\Admin\RepairManagementController::class, 'index']);


    //3-3公設管理
    Route::get('/publicmanagement', [App\Http\Controllers\Admin\PublicManagementController::class, 'index']);
        //3-3-1公設新增
        Route::get('/addpublic', [App\Http\Controllers\Admin\AddPublicController::class, 'index']);
        Route::resource('addpublic', App\Http\Controllers\Admin\AddPublicController::class)->only(['store', 'show', 'edit', 'update', 'destroy']);
        //3-3-2公設列表
        Route::get('/publiclist', [App\Http\Controllers\Admin\PublicListController::class, 'index']);
        //3-3-3預約簽核
        Route::get('/publicapprove', [App\Http\Controllers\Admin\PublicApproveController::class, 'index']);

    //3-4公務車預約
    Route::get('/carapproval', [App\Http\Controllers\Admin\CarApprovalController::class, 'index']);
    //3-5維修管理
    Route::get('/maintenancemanagement', [App\Http\Controllers\Admin\MaintenanceManagementController::class, 'index']);
    //3-6公告管理
    Route::get('/announcementmanagement', [App\Http\Controllers\Admin\AnnouncementManagementController::class, 'index']);
        //3-6-1電子公告
        Route::get('/electronicboard', [App\Http\Controllers\Admin\ElectronicBoardController::class, 'index']);
        //3-6-2新增公告
        Route::get('/announcement', [App\Http\Controllers\Admin\AnnouncementController::class, 'index']);
        Route::resource('announcement', App\Http\Controllers\Admin\AnnouncementController::class)->only(['store', 'show', 'edit', 'update', 'destroy']);
        
    


//4-資產管理
Route::get('/assetmanagement', [App\Http\Controllers\Admin\AssetManagementController::class, 'index']);
    //4-1社區資產
    Route::get('/communityassets', [App\Http\Controllers\Admin\CommunityAssetsController::class, 'index']);
        //4-1-1新增分類
        Route::get('/addassets', [App\Http\Controllers\Admin\AddAssetsController::class, 'index']);
        Route::resource('addassets', App\Http\Controllers\Admin\AddAssetsController::class)->only(['store', 'show', 'edit', 'update', 'destroy']);
        //4-1-2分類列表
        Route::get('/assetslist', [App\Http\Controllers\Admin\AssetsListController::class, 'index']);
        //4-1-新增設備
        Route::get('/adddevice', [App\Http\Controllers\Admin\AddDeviceController::class, 'index']);
        Route::resource('adddevice', App\Http\Controllers\Admin\AddDeviceController::class)->only(['store', 'show', 'edit', 'update', 'destroy']);

    //4-2公務車管理
    Route::get('/carmanagement', [App\Http\Controllers\Admin\CarManagementController::class, 'index']);
        //4-2-1新增公務車
        Route::get('/addcar', [App\Http\Controllers\Admin\AddCarController::class, 'index']);
        Route::resource('addcar', App\Http\Controllers\Admin\AddCarController::class)->only(['store', 'show', 'edit', 'update', 'destroy']);


//5-規範管理
Route::get('/standardizedmanagement', [App\Http\Controllers\Admin\StandardizedManagementController::class, 'index']);
    //5-1維護計劃
    Route::get('/maintenanceplan', [App\Http\Controllers\Admin\MaintenancePlanController::class, 'index']);
        //5-1-1編輯計劃
        Route::get('/editmaintenance', [App\Http\Controllers\Admin\EditMaintenanceController::class, 'index']);
        Route::resource('editmaintenance', App\Http\Controllers\Admin\EditMaintenanceController::class)->only([ 'edit', 'update']);

    //5-2流程規範
    Route::get('/processspecifications', [App\Http\Controllers\Admin\ProcessSpecificationsController::class, 'index']);
        //5-2-1編輯規範
        Route::get('/editprocesss', [App\Http\Controllers\Admin\EditProcessController::class, 'index']);
        Route::resource('editprocesss', App\Http\Controllers\Admin\EditProcessController::class)->only([ 'edit', 'update']);

    //5-3資材計劃
    Route::get('/materialsplan', [App\Http\Controllers\Admin\MaterialsPlanController::class, 'index']);
        //5-3-1編輯規範
        Route::get('/editmaterials', [App\Http\Controllers\Admin\EditMaterialsController::class, 'index']);
        Route::resource('editmaterials', App\Http\Controllers\Admin\EditMaterialsController::class)->only([ 'edit', 'update']);
        
    //5-4長期計劃
    Route::get('/longtimeplan', [App\Http\Controllers\Admin\LongTimePlanController::class, 'index']);
        //5-4-1編輯計劃
        Route::get('/editlongtime', [App\Http\Controllers\Admin\EditLongTimeController::class, 'index']);
        Route::resource('editlongtime', App\Http\Controllers\Admin\EditLongTimeController::class)->only([ 'edit', 'update']);

    //5-5住戶規章
    Route::get('/residentsregulations', [App\Http\Controllers\Admin\ResidentsRegulationsController::class, 'index']);
        //5-5-1編輯規章
        Route::get('/editregulations', [App\Http\Controllers\Admin\EditRegulationsController::class, 'index']);
        Route::resource('editregulations', App\Http\Controllers\Admin\EditRegulationsController::class)->only([ 'edit', 'update']);


    //5-6行政表單
    Route::get('/administrativeforms', [App\Http\Controllers\Admin\AdministrativeFormsController::class, 'index']);
    //5-7社區報表
    Route::get('/communityreports', [App\Http\Controllers\Admin\CommunityReportsController::class, 'index']);


//6-財務管理
Route::get('/financialmanagement', [App\Http\Controllers\Admin\FinancialManagementController::class, 'index']);
    //1日常收費
    Route::get('/dailycharges', [App\Http\Controllers\Admin\DailyChargesController::class, 'index']);
    //2日常應付
    Route::get('/dailycoping', [App\Http\Controllers\Admin\DailyCopingController::class, 'index']);
    //3表單列印
    Route::get('/formprinting', [App\Http\Controllers\Admin\FormPrintingController::class, 'index']);


//7-app住戶專用
Route::get('/document', [App\Http\Controllers\Admin\DocumentController::class, 'index']);
//1公告
Route::get('/assets', [App\Http\Controllers\Admin\AssetsController::class, 'index']);
//2報修管理
Route::get('/assets', [App\Http\Controllers\Admin\AssetsController::class, 'index']);
//3公設管理
Route::get('/assets', [App\Http\Controllers\Admin\AssetsController::class, 'index']);
//4公務車預約
Route::get('/assets', [App\Http\Controllers\Admin\AssetsController::class, 'index']);
//5包裹
Route::get('/assets', [App\Http\Controllers\Admin\AssetsController::class, 'index']);
//6費用
Route::get('/assets', [App\Http\Controllers\Admin\AssetsController::class, 'index']);
//7表單
Route::get('/assets', [App\Http\Controllers\Admin\AssetsController::class, 'index']);
//8規章
Route::get('/assets', [App\Http\Controllers\Admin\AssetsController::class, 'index']);
//9報表
Route::get('/assets', [App\Http\Controllers\Admin\AssetsController::class, 'index']);
