<?php

namespace App\Models\User;

use App\Models\User\Role;
use App\Models\User\UserRole;
use App\Models\Traits\TableName;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use TableName;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'phone', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne('\App\Models\User\Profile');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\User\Role', 'user_roles');
    }

    public function materialServices()
    {
        return $this->belongsToMany('App\Models\User\MaterialService', 'user_material_services');
    }

    public function skillSpecialtys()
    {
        return $this->belongsToMany('App\Models\User\SkillSpecialty', 'user_skill_specialtys');
    }

    public function logging()
    {
        return $this->hasOne('\App\Models\User\Logging');
    }

    public function priceds()
    {
        return $this->belongsToMany('\App\Models\Billing\Priced', 'user_priceds');
    }

    public function userPriceds()
    {
        return $this->hasMany('\App\Models\User\UserPriced');
    }

    public function scopeAdmins(Builder $query)
    {
        return $this->queryLeftJoinRole($query, Role::admin());
    }
    
    public function scopeContractors(Builder $query)
    {
        return $this->queryLeftJoinRole($query, Role::contractor());
    }

    public function scopeCustomers(Builder $query)
    {
        return $this->queryLeftJoinRole($query, Role::customer());
    }

    public function scopeProjectManagers(Builder $query)
    {
        return $this->queryLeftJoinRole($query, Role::projectManager());
    }

    public function scopeVendors(Builder $query)
    {
        return $this->queryLeftJoinRole($query, Role::vendor());
    }

    public function scopeSalesAssociates(Builder $query)
    {
        return $this->queryLeftJoinRole($query, Role::salesAssociate());
    }

    public function scopeNotRoles(Builder $query)
    {
        return $this->queryLeftJoinNotRole($query, Role::salesAssociate());
    }

    private function queryLeftJoinRole(Builder $query, Role $role) {
        return $query->select(User::getTableName().'.*')->leftJoin(UserRole::getTableName(), function($join) {
            $join->on(UserRole::getTableName().'.user_id', '=', User::getTable().'.id');
        })->where(UserRole::getTableName().'.role_id', '=', $role->id);
    }

    private function queryLeftJoinNotRole(Builder $query, Role $role) {
        return $query->select(User::getTableName().'.*')->leftJoin(UserRole::getTableName(), function($join) {
            $join->on(UserRole::getTableName().'.user_id', '=', User::getTable().'.id');
        })->whereNull(UserRole::getTableName().'.role_id');
    }

    public function orders()
    {
        return $this->hasMany('\App\Models\User\Order');
    }

    public function order()
    {
        return $this->hasOne('\App\Models\User\Order');
    }

    public function isAdmin() {
        if (!($role = Role::where('name', Role::ROLE_ADMIN)->first())) {
            return false;
        }

        $userRole = UserRole::where([
            'user_id' => $this->id,
            'role_id' => $role->id
        ])->get();

        return $userRole->isNotEmpty();
    }

    public function isCustomer() {
        if (!($role = Role::where('name', Role::ROLE_CUSTOMER)->first())) {
            return false;
        }

        $userRole = UserRole::where([
            'user_id' => $this->id,
            'role_id' => $role->id
        ])->get();

        return $userRole->isNotEmpty();
    }

    public function isVendor() {
        if (!($role = Role::where('name', Role::ROLE_VENDOR)->first())) {
            return false;
        }

        $userRole = UserRole::where([
            'user_id' => $this->id,
            'role_id' => $role->id
        ])->get();

        return $userRole->isNotEmpty();
    }

    public function isContractor() {
        if (!($role = Role::where('name', Role::ROLE_CONTRACTOR)->first())) {
            return false;
        }

        $userRole = UserRole::where([
            'user_id' => $this->id,
            'role_id' => $role->id
        ])->get();

        return $userRole->isNotEmpty();
    }

    public function isProjectManager() {
        if (!($role = Role::where('name', Role::ROLE_PROJECT_MANAGER)->first())) {
            return false;
        }

        $userRole = UserRole::where([
            'user_id' => $this->id,
            'role_id' => $role->id
        ])->get();

        return $userRole->isNotEmpty();
    }

    public function isSalesAssociate() {
        if (!($role = Role::where('name', Role::ROLE_SALES_ASSOCIATE)->first())) {
            return false;
        }

        $userRole = UserRole::where([
            'user_id' => $this->id,
            'role_id' => $role->id
        ])->get();

        return $userRole->isNotEmpty();
    }

    public function getFullNameAttribute()
    {
        if ($this->profile) {
            return $this->profile->firstname.' '.$this->profile->lastname;
        } else {
            return $this->name;
        }
    }
    
}
