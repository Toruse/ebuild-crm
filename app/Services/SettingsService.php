<?php

namespace App\Services;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Repositories\User\RoleRepository;
use App\Repositories\Billing\PricedRepository;

class SettingsService
{
    protected $roleRepository;
    protected $pricedRepository;

    public function __construct(RoleRepository $roleRepository, PricedRepository $pricedRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->pricedRepository = $pricedRepository;
    }

    public function pluckListRole($key = 'id', $value = 'name')
    {
        return ['' => 'None'] + $this->roleRepository->pluckListRole();
    }

    public function updateSettings(User $user, $request) {        
        $this->roleRepository->setUserRole($user, $request);
        $this->pricedRepository->setPricedUser($user, $request);
        
        return true;
    }
}