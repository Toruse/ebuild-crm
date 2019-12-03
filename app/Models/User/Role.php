<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Role extends Model
{
    const ROLE_ADMIN = 'admin';
    const ROLE_CUSTOMER = 'client';
    const ROLE_VENDOR = 'vendor';
    const ROLE_CONTRACTOR = 'contractor';
    const ROLE_PROJECT_MANAGER = 'project_manager';
    const ROLE_SALES_ASSOCIATE = 'sales_associate';

    public function scopeAdmin(Builder $query)
    {
        return $query->where('name', self::ROLE_ADMIN)->first();
    }

    public function scopeContractor(Builder $query)
    {
        return $query->where('name', self::ROLE_CONTRACTOR)->first();
    }

    public function scopeCustomer(Builder $query)
    {
        return $query->where('name', self::ROLE_CUSTOMER)->first();
    }

    public function scopeProjectManager(Builder $query)
    {
        return $query->where('name', self::ROLE_PROJECT_MANAGER)->first();
    }

    public function scopeVendor(Builder $query)
    {
        return $query->where('name', self::ROLE_VENDOR)->first();
    }

    public function scopeSalesAssociate(Builder $query)
    {
        return $query->where('name', self::ROLE_SALES_ASSOCIATE)->first();
    }

    public static function getListRole()
    {
        return [
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_CUSTOMER => 'Client',
            self::ROLE_VENDOR => 'Vendor',
            self::ROLE_CONTRACTOR => 'Contractor',
            self::ROLE_PROJECT_MANAGER => 'Project Manager',
            self::ROLE_SALES_ASSOCIATE => 'Sales Associate',
        ];
    }
}
