<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Notifications\TestEnrollment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    // notifications
    public function index(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'notifications' => $user->notifications()->latest()->get()
        ]);
    }


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
            'message' => 'Notification sent successfully'
        ]);
    }


    public function destroy($id)
    {
        auth()->user()->notifications()->where('id', $id)->firstOrFail()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully'
        ]);
    }
}
