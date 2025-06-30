<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Schedule;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Define a broadcast channel named "chat.{id}".
// This channel ensures that only authenticated users with a matching ID can subscribe to the channel.
// The callback checks if the ID of the authenticated user matches the ID in the channel name.
Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Schedule::command('app:task-status-command')->everySecond();
