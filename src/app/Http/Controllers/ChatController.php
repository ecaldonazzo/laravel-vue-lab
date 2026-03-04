<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:50',
            'message' => 'required|string|max:500',
        ]);

        $time = now()->format('H:i');

        broadcast(new MessageSent(
            name:    $request->name,
            message: $request->message,
            time:    $time,
        ))->toOthers();

        return response()->json(['status' => 'sent', 'time' => $time]);
    }
}
