<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Services\TaskCommentService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    private $userService;
    private $taskCommentService; 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService, TaskCommentService $taskCommentService)
    {
        $this->middleware('guest')->except('logout');
        
        $this->userService = $userService;
        $this->taskCommentService = $taskCommentService;
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return $request->only($this->username(), 'password');
        } 

      
        if ($this->validatePhone($request)) {
            return [
                'phone' => $request->email,
                'password' => $request->password,
            ];        
        }
        
        return [
            'name' => $request->email,
            'password' => $request->password,
        ];        
    }

    protected function validatePhone(Request $request) {
        $validatorPhone = Validator::make($request->all(), [
            'email' => 'required|phone:AUTO,US',
        ]);

        return !$validatorPhone->fails();
    }

    protected function authenticated(Request $request, $user)
    {
        $this->validateLogging($request);
        $this->userService->insertInfoLogging($request, $user);
    }

    protected function validateLogging(Request $request) {
        $this->validate($request, [
            'latitude' => 'nullable|string|max:20',
            'longitude' => 'nullable|string|max:20',
            'user_time' => 'nullable|date_format:Y-m-d H:i:s',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string',
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->beforeLogout($request);

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    public function beforeLogout(Request $request) {
        $this->validateLogging($request);
        $this->userService->updateInfoLogging($request);
        $this->taskCommentService->addTasksTodayComments($request);
    }
}
