<?php

namespace App\Repositories\User;

use App\Models\User\Role;
use App\Models\User\User;
use App\Models\User\UserRole;

class RoleRepository
{
    public function pluckListRole($key = 'id', $value = 'name')
    {
        $listRole = Role::getListRole();
        return Role::orderBy('name')
            ->pluck($value, $key)
            ->map(function ($value) use ($listRole) {
                return $listRole[$value] ?? '';
            })
            ->all();
    }

    public function setUserRole(User $user, $request) {
        UserRole::where('user_id', $user->id)->delete();

        if ($request->role) {
            UserRole::create([
                'role_id' => $request->role,
                'user_id' => $user->id,
            ]);
        }

        return true;
    }
}