<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\PasswordReset;
use App\Jobs\PasswordResetEmailJob;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ResetPasswordRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        PasswordResetEmailJob::dispatch(
            PasswordReset::create(
                array_merge(
                    ['email' => $user->email],
                    ['token' => Str::random(60)]
                )
            )
        );

        return true;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
