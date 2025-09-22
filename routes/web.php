<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Team\TeamHomeController;
use App\Http\Controllers\User\UserHomeController;
use App\Http\Controllers\User\RequestmeetingController;
use App\Http\Controllers\admin\AdminRegisteredUsersController;
use App\Http\Controllers\admin\AdminChatsController;
use App\Http\Controllers\ZoomMeetingController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\admin\AdminProjectFormController;
use App\livewire\Counter;
use App\livewire\CounterTest;
use App\livewire\Chat;
use App\livewire\A;




// Route::get('/it-service-loading-page', [UserHomeController::class, 'ITServiceLoadingPage']);
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        // Route::post('/authentication', [AdminController::class, 'authenticate'])->name('admin.authenticate');
    });
});
Route::get('/countertest',[ Controller::class, 'livewireTest']);
Route::get('/counter', App\Livewire\CounterTest::class);

Route::group(['middleware' => ['admin.auth']], function () {

    Route::get('/logout', [AdminHomeController::class, 'logout'])->name('logout');
    Route::post('/user-leaving', function () {
        if (auth()->check()) {
            auth()->user()->details()->updateOrCreate([], [
                'web_last_left_at' => now(),
            ]);
            Log::info('User left: ' . auth()->id());
        } else {
            Log::info('User left but not authenticated');
        }

        return response()->noContent();
    });
    Route::post('/user-active', function () {
        if (auth()->check()) {
            auth()->user()->active_status = 1;
            auth()->user()->save();
            auth()->user()->detail()->updateOrCreate([], [
                'chat_web_last_active_at' => now(),
            ]);
        }

        return response()->noContent();
    });
});
Route::group(['middleware' => ['admin.auth','track.user.activity']], function () {

    // routes/web.php
    // Route::get('/chat', Chat::class)->name('chat');

    Route::group(['middleware' => ['check_dashboard_access:admin']], function () {

        Route::get('/admin/user-tracking', [AdminHomeController::class, 'userTracking'])->name('admin.user-tracking');
        Route::get('/user-activity/ajax', [AdminHomeController::class, 'userActivityAjax'])->name('admin.user-activity.ajax');


        Route::get('admindashboard', [AdminHomeController::class, 'index'])->name('admin.dashboard');
        Route::get('admin/registeredusers/', [AdminRegisteredUsersController::class, 'registeredusers'])->name('admin.registeredusers');
        Route::get('admin/register-service-members/', [AdminRegisteredUsersController::class, 'registeredService'])->name('admin.register-service');
        Route::get('admin/registeredteammembers/', [AdminRegisteredUsersController::class, 'registeredteammembers'])->name('admin.registeredteammembers');
        Route::get('admin/registeredusers/edit/{id}', [AdminRegisteredUsersController::class, 'useredit'])->name('admin.registeredusers.edit');
        Route::put('admin/registeredusers/update/{id}', [AdminRegisteredUsersController::class, 'userupdate'])->name('admin.registeredusers.update');
        Route::get('admin/registeredusers/del/{id}', [AdminRegisteredUsersController::class, 'userdel'])->name('admin.registeredusers.del');
        Route::get('admin/chats/chatsfetch/', [AdminChatsController::class, 'latemessage'])->name('admin.chats.chatsfetch');
        Route::get('admin/chats/user/api', [AdminChatsController::class, 'fetchUserApiData'])->name('admin.chatuser.api');
        Route::get('admin/chats/team/api', [AdminChatsController::class, 'fetchTeamApiData'])->name('admin.chatteam.api');
        Route::get('admin/userquestion', [AdminChatsController::class, 'userquestion'])->name('admin.userquestion');
        Route::get('admin/projectform', [AdminProjectFormController::class, 'projectform'])->name('admin.projectform');
        Route::post('inbox/store', [AdminChatsController::class, 'inboxstore'])->name('inbox.store');
        Route::post('projectform/submit', [AdminProjectFormController::class, 'projectformsubmit'])->name('projectform.submit');
        Route::get('allprojectform/submit', [AdminProjectFormController::class, 'allprojectdata'])->name('allprojectform');
        Route::get('/download/{file}', [AdminProjectFormController::class, 'download'])->name('file.download');
        
        //admin tickets
        Route::get('admin/ticket/', [AdminChatsController::class, 'complainfetch'])->name('admin.complain');
        Route::get('admin/ticket/del/{id}', [AdminChatsController::class, 'complainfetchdel'])->name('admin.complain.del');
        Route::post('admin/ticket/{id}/update-status', [AdminChatsController::class, 'updateStatus'])->name('admin.complain.update');
        Route::get('admin/completed-tickets', [AdminChatsController::class, 'completedtickets'])->name('admin.completedtickets');
        Route::get('admin/in-progress-tickets', [AdminChatsController::class, 'pendingtickets'])->name('admin.pendingtickets');
        Route::get('admin/received-ticktets', [AdminChatsController::class, 'receivedticktets'])->name('admin.receivedticktets');
        
        Route::get('admin/services-ticket/', [AdminChatsController::class, 'tickets'])->name('services.tickets');
        Route::get('admin/services-completed-tickets', [AdminChatsController::class, 'serviceCompletedTickets'])->name('services.completedtickets');
        Route::get('admin/services-in-progress-tickets', [AdminChatsController::class, 'servicePendingTickets'])->name('services.pendingtickets');
        Route::get('admin/services-received-ticktets', [AdminChatsController::class, 'serviceReceivedTickets'])->name('services.receivedticktets');

        // followup section
        Route::get('admin/followup', [AdminChatsController::class, 'followup'])->name('admin.followup');
        Route::get('admin/followup3', [AdminChatsController::class, 'followup3'])->name('admin.followup3');
        Route::get('admin/followup6', [AdminChatsController::class, 'followup6'])->name('admin.followup6');
        Route::get('admin/followup9', [AdminChatsController::class, 'followup9'])->name('admin.followup9');
        
        // completedtask
        Route::get('admin/followupform/{id}/{cname}/{a}/{phone?}', [AdminChatsController::class, 'followupform'])->name('admin.followupform');
        Route::post('admin/followupformsubmit/', [AdminChatsController::class, 'followupformsubmit'])->name('admin.followupformsubmit');
        Route::get('admin/completedtask', [AdminChatsController::class, 'completedtask'])->name('admin.completedtask');
        
        Route::get('admin/completefollowup',[AdminChatsController::class, 'completefollowup'])->name('admin.completefollowup');
        Route::get('admin/completefollowup3', [AdminChatsController::class, 'completefollowup3'])->name('admin.completefollowup3');
        Route::get('admin/completefollowup6', [AdminChatsController::class, 'completefollowup6'])->name('admin.completefollowup6');
        Route::get('admin/completefollowup9', [AdminChatsController::class, 'completefollowup9'])->name('admin.completefollowup9');
        Route::post('admin/complete-update-approve-status', [AdminChatsController::class, 'completedUpdateApproveStatus'])->name('update.admim.approve.status');
        
        Route::get('admin/add-users', [AdminChatsController::class, 'usersInsert'])->name('admin.usersInsert');

    });

    Route::group(['middleware' => ['check_dashboard_access:team']], function () {
        Route::get('/teamdashboard', [AdminChatsController::class, 'teamlatemessage'])->name('team.dashboard');
        Route::put('/reason/{id}', [AdminChatsController::class, 'storeReason'])->name('team.reason');
        // Route::get('team/projectform', [AdminProjectFormController::class, 'projectform'])->name('team.projectform');
        // Route::post('team/projectform/submit', [AdminProjectFormController::class, 'projectformsubmit'])->name('teamprojectform.submit');
        // Route::get('team/download/{file}', [AdminProjectFormController::class, 'download'])->name('teamfile.download');
        // teamfollowup section

        Route::get('team/ticket/', [TeamHomeController::class, 'tickets'])->name('team.tickets');
        Route::post('team/ticket/{id}/update-status', [TeamHomeController::class, 'updateStatus'])->name('team.tickets.update');
        Route::get('team/completed-tickets', [TeamHomeController::class, 'completedtickets'])->name('team.completedtickets');
        Route::get('team/in-progress-tickets', [TeamHomeController::class, 'pendingtickets'])->name('team.pendingtickets');
        Route::get('team/received-ticktets', [TeamHomeController::class, 'receivedticktets'])->name('team.receivedticktets');
        
        Route::get('team/followup',[TeamHomeController::class, 'followup'])->name('team.followup');
        Route::get('team/followup3', [TeamHomeController::class, 'followup3'])->name('team.followup3');
        Route::get('team/followup6', [TeamHomeController::class, 'followup6'])->name('team.followup6');
        Route::get('team/followup9', [TeamHomeController::class, 'followup9'])->name('team.followup9');
        Route::post('team/update-communication-type', [TeamHomeController::class, 'updateCommunicationType'])->name('update.communication.type');
        Route::post('/nested-form-submit', [TeamHomeController::class, 'submitNestedForm'])->name('nested.form.submit');
    });

    Route::group(['middleware' => ['check_dashboard_access:user']], function () {
        
        // Route::get('/test/web/sockets', [UserHomeController::class, 'testWebSockets']);

        
        Route::post('/user/category/delete', [UserHomeController::class, 'deleteDesign'])->name('user.category.delete');
        Route::post('/user/save-selected-category', [UserHomeController::class, 'saveSelectedCategory']);
        Route::post('/user/edit-selected-category', [UserHomeController::class, 'editSubCategoryToggle']);
        Route::post('/user/update-main-category', [UserHomeController::class, 'updateMainCategoryName'])->name('user.update.main.category');
        Route::post('/user/upload/product/image', [UserHomeController::class, 'uploadProductImage'])->name('product.image.upload');


        
        Route::get('/userdashboard', [UserHomeController::class, 'index'])->name('user.dashboard');
        Route::get('/userticket', [UserHomeController::class, 'complain'])->name('user.complain');
        // Route::get('/usercomplain', [UserHomeController::class, 'complain'])->name('user.complain');
        Route::get('user/inbox/', [AdminChatsController::class, 'inbox'])->name('user.inbox');
        Route::get('user/payment', [UserHomeController::class, 'payment'])->name('user.payment');
        Route::get('/user/modification/{id?}', [UserHomeController::class, 'modification'])->name('user.modification');
        Route::post('user/submitmodification', [UserHomeController::class, 'submitmodification'])->name('user.submitmodification');

        Route::get('/createticket', [UserHomeController::class, 'createTicket'])->name('user.createticket');
        Route::get('/bvdetails', [UserHomeController::class, 'bvDetails'])->name('user.bvdetails');
        Route::post('/bvdetailupload', [UserHomeController::class, 'bvDetailsUpload'])->name('user.bvdetailupload');
        Route::post('user/submitcomplain/', [UserHomeController::class, 'submitcomplain'])->name('user.submitcomplain');
        Route::get('/projectdetail', [UserHomeController::class, 'projectdetail'])->name('user.projectdetail');
        Route::get('/project-view', [UserHomeController::class, 'projectView'])->name('user.project.view');
        // In your routes/web.php
        Route::get('/project-links', [UserHomeController::class, 'projectView'])->name('user.project.view');
        
        Route::post('/verify-item', [UserHomeController::class, 'verifyItem'])->name('verify.item');

        
        
        Route::get('/projectform', [UserHomeController::class, 'projectform'])->name('user.projectform');
        Route::post('/projectformstore', [UserHomeController::class, 'projectformstore'])->name('user.projectformstore');
        Route::get('/catagory', [UserHomeController::class, 'catagory'])->name('user.catagory');
        Route::post('/catagorystore', [UserHomeController::class, 'catagorystore'])->name('user.catagorystore');
        Route::get('/file', [UserHomeController::class, 'file'])->name('user.file');
        Route::post('/fileupload', [UserHomeController::class, 'fileupload'])->name('user.fileupload');
        Route::get('/homeprojectform', [UserHomeController::class, 'homeprojectform'])->name('homeuser.projectform');
        Route::post('/homeprojectformstore', [UserHomeController::class, 'homeprojectformstore'])->name('homeuser.projectformstore');
        Route::get('/homecatagory', [UserHomeController::class, 'homecatagory'])->name('homeuser.catagory');
        Route::post('/homecatagorystore', [UserHomeController::class, 'homecatagorystore'])->name('homeuser.catagorystore');
        Route::get('/homefile/{project}', [UserHomeController::class, 'homefile'])->name('homeuser.file');
        Route::post('/homefileupload', [UserHomeController::class, 'homefileupload'])->name('homeuser.fileupload');
        Route::get('/downloadclient/{file}', [UserHomeController::class, 'downloadclient'])->name('file.downloadclient');
        Route::get('user/training', [UserHomeController::class, 'training'])->name('user.training');
        Route::post('/reviews', [UserHomeController::class, 'storereview'])->name('reviews.store');
        Route::get('user/design', [UserHomeController::class, 'design'])->name('user.design');
        Route::post('user/storedesign', [UserHomeController::class, 'storedesign'])->name('user.storedesign');
        Route::get('user/productdesign', [UserHomeController::class, 'productdesign'])->name('user.productdesign');
        Route::post('user/productstoredesign', [UserHomeController::class, 'Storeproductdesign'])->name('user.productstoredesign');


    });

    Route::get('/chatify', [UserHomeController::class, 'chat'])->name('vendor.chatify.pages.app');
    Route::get('/zoom-meetings/create', [ZoomMeetingController::class, 'create'])->name('zoom-meetings.create');
    Route::post('/zoom-meetings/store', [ZoomMeetingController::class, 'store'])->name('zoom-meetings.store');
    //register user

    //chats
    Route::get('admin/chats/', [AdminChatsController::class, 'Chat'])->name('admin.chats');
    Route::get('/admin/chatsfetch', [AdminChatsController::class, 'getChatData'])->name('admin.chatsfetch');
    Route::get('admin/chats/del/{id}', [AdminChatsController::class, 'Chatdel'])->name('admin.chats.del');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('/register/store', [AuthController::class, 'registerstore'])->name('register.store');
});
//user
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/authentication', [AuthController::class, 'authenticate'])->name('authenticate');




