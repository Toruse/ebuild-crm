<?php

namespace App\Rules;

use App\Models\User\Role;
use App\Models\User\User;
use App\Models\User\UserRole;
use Illuminate\Contracts\Validation\Rule;

class EmailAdminManager implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->isUserByEmailAdminManager($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This e-mail is reserved for another user.';
    }

    /**
     * Undocumented function
     *
     * @param string $mail
     * @return boolean
     */
    public function isUserByEmailAdminManager($mail) {
        return User::leftJoin(UserRole::getTableName(), function($join) {
            $join->on(UserRole::getTableName().'.user_id', '=', User::getTableName().'.id');
        })
            ->where(function ($query) {
                $query->where(UserRole::getTableName().'.role_id', Role::projectManager()->id)
                    ->orWhere(UserRole::getTableName().'.role_id', Role::admin()->id);
            })
            ->where(User::getTableName().'.email', $mail)
            ->get()
            ->isEmpty();
    }
}
