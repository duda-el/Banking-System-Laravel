<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($request->user()->notifications);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);

        if ($notification->notifiable_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $notification->update(['read_at' => now()]);

        return response()->json(['message' => 'Notification marked as read']);
    }
}
