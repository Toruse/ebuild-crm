<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use App\Services\PricedService;
use App\Services\SettingsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SettingsUpdateRequest;

class SettingsController extends Controller
{
    private $settingsService;
    private $pricedService;

    public function __construct(SettingsService $settingsService, PricedService $pricedService)
    {
        $this->settingsService = $settingsService;
        $this->pricedService = $pricedService;
    }

    public function edit($userId) {
        $user = User::findOrFail($userId);

        return view('user.settings.edit', [
            'user' => $user,
            'listRoles' => $this->settingsService->pluckListRole(),
            'listPriced' => $this->pricedService->pluckListPriced(),
        ]);
    }

    public function update(SettingsUpdateRequest $request, $userId) {
        $user = User::findOrFail($userId);

        $this->settingsService->updateSettings($user, $request);

        return redirect()->route('customers.index');
    }
}