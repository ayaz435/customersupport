<?php

use App\Http\Controllers\admin\AdminHomeController;
use http\Client\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\Api\AdminApiController;
use App\Http\Controllers\Api\TeamApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\UserStatusController;
use App\Http\Controllers\admin\AdminProjectFormController;



Route::post('/login', [AuthController::class, 'apilogin'])->name('authenticate');



Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'apiLogout']);
Route::middleware('auth:sanctum')->post('/logout-all', [AuthController::class, 'apiLogoutAll']);

Route::middleware(['api.auth:sanctum'])->group(function () {
    Route::post('/user-leaving', function () {
        if (auth()->check()) {
            auth()->user()->detail()->updateOrCreate([], [
                'app_last_left_at' => now(),
            ]);
        }

        return response()->noContent();
    });
    Route::post('/user-back', function () {
        if (auth()->check()) {
            auth()->user()->detail()->updateOrCreate([], [
                'app_last_active_at' => now(),
                'app_last_visited_url' => request()->fullUrl(),
            ]);
        }
        return response()->noContent();
    });
});

Route::prefix('admin')->middleware(['api.auth:sanctum','track.api.activity'])->group(function () {
    
    Route::delete('/users/{id}', [AdminApiController::class, 'deleteUserApi']);
    Route::get('/userquestion', [AdminApiController::class, 'userquestion'])->name('api.admin.userquestion');
    Route::get('/late-messages', [AdminApiController::class, 'latemessage'])->name('api.late.messages');
    Route::get('/users', [AdminApiController::class, 'allUsers'])->name('api.allusers');
    Route::post('/client-data', [AdminApiController::class, 'clientData'])->name('api.clientdata');
    Route::get('/complete-task', [AdminApiController::class, 'completeTask'])->name('api.complete.task');
    Route::put('/followup/complete-status', [AdminApiController::class, 'completedUpdateApproveStatus'])->name('api.complete.status');
    Route::get('/registered-users', [AdminApiController::class, 'registeredUsers'])->name('api.registeredusers');
    Route::get('/team', [AdminApiController::class, 'allTeam'])->name('api.allTeam');
    Route::get('/service-members', [AdminApiController::class, 'getServiceMembers'])->name('api.getServiceMembers');
    Route::post('/announcement-inbox', [AdminApiController::class, 'announcementInbox'])->name('api.announcementInbox');
    Route::get('/index', [AdminApiController::class, 'index'])->name('api.index');
    Route::get('/tickets', [AdminApiController::class, 'tickets'])->name('api.tickets');
    Route::put('/tickets/{id}/status', [AdminApiController::class, 'updateStatus'])->name('api.tickets.update');
    Route::put('/users/{id}', [AdminApiController::class, 'updateUser'])->name('api.user.update');
    Route::post('/followup-assign-task', [AdminApiController::class, 'followupAssignTask'])->name('api.followup.assign.task');
    Route::get('/active-team-members', [AdminApiController::class, 'activeTeamMembers'])->name('api.active.team.members');
});

Route::prefix('team')->middleware(['api.auth:sanctum','track.api.activity'])->group(function () {
    Route::get('/logout', [AdminHomeController::class, 'logout'])->name('logout');
    Route::get('/team-dashboard', [TeamApiController::class, 'teamDashboard'])->name('api.team.dashboard');
    Route::put('/update-followup-status', [TeamApiController::class, 'updateFollowupStatus'])->name('api.team.updateFollowupStatus');
    Route::put('/late-messages/{id}/reason', [TeamApiController::class, 'updateReason']);
});

Route::prefix('client')->middleware(['api.auth:sanctum','track.api.activity'])->group(function () {
    Route::get('/missing-data', [UserApiController::class, 'missingDataCheck']);
    Route::get('/annaouncements', [UserApiController::class, 'annaouncement']);
    Route::get('/all-team-members', [UserApiController::class, 'allTeamMembers']);
    Route::get('/tickets', [UserApiController::class, 'tickets']);
    Route::post('/create-ticket', [UserApiController::class, 'createTicket']);
    Route::post('/project-form-store', [UserApiController::class, 'projectFormStore']);
    Route::get('/compnay-details-form-data', [UserApiController::class, 'compnayDetailsFormData']);
    Route::post('/submit-product-design', [UserApiController::class, 'submitProductDesign']);
    Route::post('/product-design-store', [UserApiController::class, 'Storeproductdesign']);
    Route::post('/save-selected-category', [UserApiController::class, 'saveSelectedCategory']);
    Route::post('/edit-selected-category', [UserApiController::class, 'editSubCategoryToggle']);
    Route::post('/catagory-store', [UserApiController::class, 'catagoryStore']);
    Route::get('/catagory', [UserApiController::class, 'catagory']);
    Route::put('/update-main-category', [UserApiController::class, 'updateMainCategoryName']);
    Route::post('/product-delete', [UserApiController::class, 'deleteDesign']);
    Route::post('/upload-product-image', [UserApiController::class, 'uploadProductImage']);
    Route::post('/submit-modification', [UserApiController::class, 'submitModificationApi']);
    // Route::get('/bv-details', [UserApiController::class, 'bvDetails']);
    Route::get('/file', [UserApiController::class, 'fileApi']);
    Route::post('/bv-details-upload', [UserApiController::class, 'bvDetailsUpload']);
    Route::post('/file-upload', [UserApiController::class, 'fileUploadApi']);
    Route::post('/reviews-store', [UserApiController::class, 'reviewsStore']);

});



Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
});
Route::get('allprojectform/submit', [AdminProjectFormController::class, 'allprojectdata'])->name('allprojectform');
Route::get('designapi', [ApiController::class, 'designapi']);
Route::get('productdesignapi', [ApiController::class, 'productdesignapi']);
Route::post('/insert-new-customer', [ApiController::class, 'insertNewUser']);
Route::post('/insert-new-team', [ApiController::class, 'insertNewTeam']);
Route::post('/add-service-member', [ApiController::class, 'addServiceMember']);
Route::put('/update-user-status', [ApiController::class, 'updateUserApprovalStatus']);

