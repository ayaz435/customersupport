<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgoraVoiceCallController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
// use App\Http\Controllers\PusherAuthController;
use App\Http\Controllers\CustomMessagesController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\ChatTransferController;
use App\Http\Controllers\ChatExportController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
// Route::get('/chatify/get-available-agents', [AgentController::class, 'getAvailableAgents'])
//     ->middleware('auth');

Route::prefix('chatify')->middleware(['web', 'auth'])->group(function () {
    Route::post('/user-leaving', function () {
        if (auth()->check()) {
            auth()->user()->active_status = 0;
            auth()->user()->save();
            auth()->user()->detail()->updateOrCreate([], [
                'chat_web_last_left_at' => now(),
            ]);
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
Route::prefix('chatify')->middleware(['web', 'auth', 'track.user.activity'])->group(function () {
    
    Route::post('/transfer-chat', [ChatTransferController::class, 'transferChat'])->name('transfer.chat');
    Route::post('/chat-history/{customer_id}', [ChatTransferController::class, 'getChatHistory'])->name('get.chat');
    // Route::get('/chat-history/{customer_id}', [ChatTransferController::class, 'getChatHistory'])->name('chat.history');
    Route::post('/fetchAgents', [CustomMessagesController::class, 'agents'])->name('fetch.agents')->name('fetch.messages');    
    
      // Export specific user's chat to admin email
    Route::post('/chat/export/email', [ChatExportController::class, 'exportToEmail'])->name('chatsummary');
        //  ->name('chat.export.email');
    
    // Download chat as file
    Route::post('/chat/export/download', [ChatExportController::class, 'downloadChat'])
         ->name('chat.export.download');
    
    // Export all chats to admin email
    Route::post('/chat/export/all-email', [ChatExportController::class, 'exportAllChatsToEmail'])
         ->name('chat.export.all.email');

    // Route::get('/get-available-agents', [App\Http\Controllers\AgentController::class, 'getAvailableAgents']);
    Route::get('/', [CustomMessagesController::class, 'index'])->name(config('chatify.routes.prefix'));
    Route::post('/idInfo', [CustomMessagesController::class, 'idFetchData']);
    Route::post('/sendMessage', [CustomMessagesController::class, 'send'])->name('send.message');
    Route::get('/chatdash', [CustomMessagesController::class, 'chatdash'])->name('chatdash');
    Route::post('/fetchMessages', [CustomMessagesController::class, 'fetch'])->name('fetch.messages');

    Route::get('/download/{fileName}', [CustomMessagesController::class, 'download'])->name(config('chatify.attachments.download_route_name'));
    Route::post('/makeSeen', [CustomMessagesController::class, 'seen'])->name('messages.seen');
    Route::get('/getContacts', [CustomMessagesController::class, 'getContacts'])->name('contacts.get');
    Route::post('/updateContacts', [CustomMessagesController::class, 'updateContactItem'])->name('contacts.update');
    // Route::get('/getContactsitems', [CustomMessagesController::class, 'getContactsitems']);
    Route::get('/getContactsitems', [CustomMessagesController::class, 'apiGetContacts']);
    Route::post('/star', [CustomMessagesController::class, 'favorite'])->name('star');
    Route::post('/favorites', [CustomMessagesController::class, 'getFavorites'])->name('favorites');
    Route::post('/chat-transfer-to', [CustomMessagesController::class, 'getchatTransferTo']);
    Route::get('/search', [CustomMessagesController::class, 'search'])->name('search');
    Route::post('/shared', [CustomMessagesController::class, 'sharedPhotos'])->name('shared');
    Route::post('/deleteConversation', [CustomMessagesController::class, 'deleteConversation'])->name('conversation.delete');
    Route::post('/deleteMessage', [CustomMessagesController::class, 'deleteMessage'])->name('message.delete');
    Route::post('/updateSettings', [CustomMessagesController::class, 'updateSettings'])->name('avatar.update');
    Route::post('/setActiveStatus', [CustomMessagesController::class, 'setActiveStatus'])->name('activeStatus.set');
    Route::get('/group/{id}', [CustomMessagesController::class, 'index'])->name('group');
    Route::get('/{id}', [CustomMessagesController::class, 'index'])->name('user');
});



Route::get('/storage-link', function () {
    $targetFolder = storage_path('app/public');
    $linkFolder = public_path('storage');

    // Check if the symbolic link already exists
    if (!file_exists($linkFolder)) {
        // Create the symbolic link
        symlink($targetFolder, $linkFolder);
    }

    return 'Storage link created';
});
// Route::post('send-chat-summary', [UserController::class, 'sendChatSummary'])->name('chatsummary');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'track.user.activity'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/online-users', [UserController::class, 'getOnlineUsers']);
   Route::get('/chatdash', [AgoraVoiceCallController::class, 'Chatdash'])->name('chatdash');
   Route::Post('/chatdash/store', [AgoraVoiceCallController::class, 'Chatdashstore'])->name('chatdash.store');

});


require __DIR__.'/auth.php';
