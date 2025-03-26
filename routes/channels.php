<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('donations.user.{userId}', function (User $user, int $userId) {
    return $user->uuid === $userId;
});
