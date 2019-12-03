<?php

namespace App\Listeners\User;

use App\Services\PricedService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendInfoExtendPricedMail;
use App\Events\User\EndDatePricedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInfoExtendPricedMailListener
{
    public function handle(EndDatePricedEvent $event)
    {
        $user = $event->user;
        $profile = $user->profile;
        $request = $event->request;

        if ($profile && $profile->email) {
            Mail::to($profile->email)->send(new SendInfoExtendPricedMail($user, $request));
            return true;
        }
        return false;
    }
}
