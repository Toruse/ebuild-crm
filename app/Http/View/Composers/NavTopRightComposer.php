<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Services\UserService;
use App\Repositories\UserRepository;

class NavTopRightComposer
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('notifications', $this->userService->getUserNewNotifications());
    }
}