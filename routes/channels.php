<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('donations.user.{userId}', function (User $user, string $userId) {
    return $user->uuid === $userId;
});
