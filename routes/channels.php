<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Define a broadcast channel named "chat.{id}".
// This channel ensures that only authenticated users with a matching ID can subscribe to the channel.
// The callback checks if the ID of the authenticated user matches the ID in the channel name.
Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});