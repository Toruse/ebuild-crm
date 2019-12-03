<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\PricedService;
use Illuminate\Support\Facades\Auth;
use App\Events\User\EndDatePricedEvent;

class PricedAccess
{

    private $pricedService;

    public function __construct(PricedService $pricedService)
    {
        $this->pricedService = $pricedService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $roles = array_slice(func_get_args(), 2);

        foreach ($roles as $role) {
            try {
                if (method_exists(Auth::user(), $role) && Auth::user()->$role()) {
                    return $next($request);
                }
            } catch (Exception $exception) {
                return redirect('access-closed');    
            }
        }

        if ($this->pricedService->getAccess()) {
            return $next($request);
        }

        if ($this->pricedService->isSendUserNotifyEmail(Auth::user())) {
            event(new EndDatePricedEvent(Auth::user(), $request));
        }
        
        return redirect('access-closed');
    }
}
