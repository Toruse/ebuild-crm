<?php

namespace App\Listeners;

use App\Events\UserMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\SendDataRegisterManagerMail as MailDataManager;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class SendDataRegisterManagerMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserMail  $event
     * @return void
     */
    public function handle(UserMail $event)
    {
        $user = $event->user;
        $profile = $user->profile;
        $fields = $event->fields;
        $email = ($profile && $profile->email)?$profile->email:$user->email;
        if ($email) {
            $password = str_random(8);
            $user->password = bcrypt($password);
            $user->save();
            $fields['password'] = $password;
            Mail::to($email)->send(new MailDataManager($user, $fields));
            return true;
        }
        return false;
    }
}
