<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Services\PricedService;

class PricedNotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('notifyPriced', PricedService::getMessageUser());
    }
}