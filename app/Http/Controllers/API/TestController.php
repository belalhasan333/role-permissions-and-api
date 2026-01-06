<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Notifications\TestEnrollment;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }


    public function index(Request $request)
    {
        $user = $request->user();
        // dd($user);
        return response()->json([
            'status' => true,
            'message' => 'Recent notifications retrieved successfully.',
            'code' => 200,
            'data' => [
                'has_unread_notifications' => $user->unreadNotifications()->exists(),
                'notifications' => $user->notifications()
                    ->latest()
                    ->get()
                    ->map(function ($notification) {
                        return [
                            'id' => $notification->id,
                            'type' => $notification->type,
                            'notifiable_type' => $notification->notifiable_type,
                            'notifiable_id' => $notification->notifiable_id,
                            'data' => $notification->data,
                            'read_at' => $notification->read_at,
                            'created_at' => $notification->created_at,
                            'updated_at' => $notification->updated_at,
                        ];
                    }),
            ],
        ], 200);
    }

    // notification read
    public function markAsRead($id)
    {
        $user = Auth::user();

        $notification = $user->unreadNotifications()->find($id);

        if (!$notification) {
            return response()->json([
                'status' => false,
                'message' => 'Notification already read',
                'code' => 404
            ], 404);
        }

        $notification->markAsRead();

        return response()->json([
            'status' => true,
            'message' => 'Notification read successfully.',
            'code' => 200
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()
            ->unreadNotifications
            ->markAsRead();
        // dd($request);

        return response()->json([
            'status' => true,
            'message' => 'All notifications marked as read',
            'code' => 200
        ]);
    }


    // Send test notification
    public function sentTestNotification()
    {
        $users = User::all();

        $data = [
            'title' => 'New content uploaded',
            'enrollmentText' => 'View Content',
            'url' => url('/'),
            'thankyou' => 'You have a new notification'
        ];

        Notification::send($users, new TestEnrollment($data));

        return response()->json([
            'success' => true,
            'message' => 'Email sent successfully'
        ]);
    }

    // Delete notification
    public function destroy($id)
    {
        Auth::user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail()
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully'
        ]);
    }
}
