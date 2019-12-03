<?php

namespace App\Services;

use App\Models\User\User;
use App\Models\Billing\Priced;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepository;
use App\Repositories\Billing\PricedRepository;

class PricedService
{
    protected $pricedRepository;

    public function __construct(PricedRepository $pricedRepository)
    {
        $this->pricedRepository = $pricedRepository;
    }

    public function getPricedsPaginate($paginate = 25)
    {
        return $this->pricedRepository->getPricedsPaginate($paginate);
    }

    public function createPriced($fields) {
        return $this->pricedRepository->createPriced($fields);
    }

    public function updatePriced(Priced $priced, $fields) { 
        $this->pricedRepository->updatePriced($priced, $fields);
        return true;
    }

    public static function getMessageUser() {
        $priced = (new UserRepository())->getActiveLastPriced(Auth::user());
        if ($priced) {
            return $priced->note;
        }
        return '';
    }

    public function getAccess() {
        return (new UserRepository())->getActiveLastPriced(Auth::user());
    }

    public function pluckListPriced($key = 'id', $value = 'name')
    {
        return ['' => 'None'] + $this->pricedRepository->pluckListPriced();
    }

    public function isSendUserNotifyEmail(User $user) {
        return $this->pricedRepository->isSendUserNotifyEmail($user);
    }
    
}