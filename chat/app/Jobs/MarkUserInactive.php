<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Carbon\Carbon;
use App\Events\UserInactive;

class MarkUserInactive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find($this->userId);
        
        if (!$user) {
            return;
        }
        $userDetail = $user->detail;
        
        if (!$userDetail) {
            return; 
        }
        if (!$user->active_status) {
            return; 
        }

        $lastActiveAt = $userDetail->chat_web_last_active_at;
        $appLastActiveAt = $userDetail->chat_app_last_active_at;

        if($lastActiveAt && $appLastActiveAt){
            if(Carbon::parse($lastActiveAt)->addMinutes(10)->isPast() && Carbon::parse($appLastActiveAt)->addMinutes(10)->isPast()){
                auth()->user()->active_status = 0;
                auth()->user()->save();

                broadcast(new UserInactive($user->id));
            }
        }else 
        if ($lastActiveAt && Carbon::parse($lastActiveAt)->addMinutes(10)->isPast()) {
            auth()->user()->active_status = 0;
            auth()->user()->save();

            broadcast(new UserInactive($user->id));
        }else
        if ($appLastActiveAt && Carbon::parse($appLastActiveAt)->addMinutes(10)->isPast()) {
            auth()->user()->active_status = 0;
            auth()->user()->save();

            broadcast(new UserInactive($user->id));
        }


    }
}