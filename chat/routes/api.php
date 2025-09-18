<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\CustomMessagesApiController as CustomMessagesApiController1;
use App\Http\Controllers\CustomMessagesController as CustomMessagesApiController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\API\ChatifyContactsApiController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('login', [LoginController::class, 'login']);
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::post('logout-all', [LoginController::class, 'logoutFromAllDevices'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum', 'track.api.activity')->get('/user', function (Request $request) {
    return $request->user();
    Route::get('/api/online-users', [UserController::class, 'getOnlineUsers']);
});


Route::middleware('guest')->group(function () {
    Route::post('register', [RegisteredUserController::class, 'store']);
    // Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth:sanctum', 'track.api.activity'])->group(function () {
    // Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::post('chatdash', [UserController::class, 'Chatdash']);

});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/user-leaving', function () {
        if (auth()->check()) {
            auth()->user()->active_status = 0;
            auth()->user()->save();
            auth()->user()->detail()->updateOrCreate([], [
                'chat_app_last_left_at' => now(),
            ]);
        }
        return response()->json(['time',auth()->user()->detail->chat_app_last_left_at]);
    });
    Route::post('/user-back', function () {
        if (auth()->check()) {
            auth()->user()->active_status = 1;
            auth()->user()->save();
            auth()->user()->detail()->updateOrCreate([], [
                'chat_app_last_active_at' => now(),
                'chat_app_last_visited_url' => request()->fullUrl(),
            ]);
        }
        return response()->noContent();
    });
});

Route::middleware(['auth:sanctum'])->prefix('chatify')->group(function () {
    Route::post('/auth', [CustomMessagesApiController::class, 'pusherAuth'])->name('api.pusher.auth');
});

Route::middleware(['auth:sanctum', 'track.api.activity'])->prefix('chatify')->group(function () {

    Route::post('/auth', [CustomMessagesApiController::class, 'pusherAuth'])->name('api.pusher.auth');
    Route::post('/idInfo', [CustomMessagesApiController::class, 'idFetchData'])->name('api.idInfo');
    Route::post('/sendMessage', [CustomMessagesApiController::class, 'send'])->name('api.send.message');
    Route::post('/fetchMessages', [CustomMessagesApiController::class, 'fetch'])->name('api.fetch.messages');
    Route::get('/download/{fileName}', [CustomMessagesApiController::class, 'download'])->name('api.chatify.download');
    Route::post('/makeSeen', [CustomMessagesApiController::class, 'seen'])->name('api.messages.seen');
    Route::get('/getContacts', [CustomMessagesApiController::class, 'apiGetContacts'])->name('api.contacts.get');
    Route::post('/updateContacts', [CustomMessagesApiController::class, 'updateContactItem'])->name('contacts.update');
    Route::post('/star', [CustomMessagesApiController::class, 'favorite'])->name('api.star');
    Route::post('/favorites', [CustomMessagesApiController::class, 'getFavorites'])->name('api.favorites');
    Route::get('/search', [CustomMessagesApiController::class, 'search'])->name('api.search');
    Route::post('/shared', [CustomMessagesApiController::class, 'sharedPhotos'])->name('api.shared');
    Route::post('/deleteConversation', [CustomMessagesApiController::class, 'deleteConversation'])->name('api.conversation.delete');
    Route::post('/updateSettings', [CustomMessagesApiController::class, 'updateSettings'])->name('api.avatar.update');
    Route::post('/setActiveStatus', [CustomMessagesApiController::class, 'setActiveStatus'])->name('api.activeStatus.set');
    Route::post('/client-call-dialing', [CustomMessagesApiController::class, 'CallDialing'])->name('api.call.dialing');
    Route::post('/client-call-timeout', [CustomMessagesApiController::class, 'callTimeout'])->name('api.call.timeout');
    Route::post('/user-typing', [CustomMessagesApiController::class, 'userTyping'])->name('api.user.typing');
    // Route::post('logout', [AuthenticatedSessionController::class, 'apiDestroy'])->name('logout');
    Route::get('/user/{id}/active-status', [CustomMessagesApiController::class,'userActiveStatus']);
    Route::get('/conversations/{userId}/messages', [CustomMessagesApiController::class, 'getMessages']);

});



