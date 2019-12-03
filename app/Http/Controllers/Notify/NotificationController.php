<?php

namespace App\Http\Controllers\Notify;

use App\Services\UserService;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function markAllViewed()
    {
        $this->userService->markAllViewed();

        return response()->json([
            'status' => 'ok',
        ]);
    }    

    public function markViewed($notificationId)
    {
        if ($this->userService->markViewed($notificationId)) {
            return response()->json([
                'status' => 'ok',
            ]);
        }

        return response()->json([
            'status' => 'error',
        ]);
    }    

    public function news()
    {
        $notifications = $this->userService->getUserNewNotifications();

        return response()->json([
            'status' => 'ok',
            'html' => view('notify.notification.news', [
                'notifications' => $notifications
            ])->render(),
            'count' => $notifications->count(),
        ]);
    }    
}