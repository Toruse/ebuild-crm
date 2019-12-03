<?php

namespace App\Repositories\User;

use Carbon\Carbon;
use App\Models\User\Role;
use App\Models\User\User;
use App\Models\User\Order;
use App\Models\User\Profile;
use App\Models\User\UserRole;

class UserRepository
{

    public function getAdminsPaginate($paginate = 25)
    {
        return User::with('profile')->admins()->paginate($paginate);
    }

    public function getContractorsPaginate($paginate = 25)
    {
        return User::with('profile')->contractors()->paginate($paginate);
    }

    public function getCustomersPaginate($paginate = 25)
    {
        return User::with('profile')->customers()->paginate($paginate);
    }

    public function getProjectManagersPaginate($paginate = 25)
    {
        return User::with('profile')->projectManagers()->paginate($paginate);
    }

    public function getSalesAssociatesPaginate($paginate = 25)
    {
        return User::with('profile')->salesAssociates()->paginate($paginate);
    }

    public function getVendorsPaginate($paginate = 25)
    {
        return User::with('profile')->vendors()->paginate($paginate);
    }

    public function pluckProjectManagers($key = 'id', $value = 'name')
    {
        $tabeName = User::getTableName();
        return User::projectManagers()->orderBy($tabeName.'.'.$value)->pluck($tabeName.'.'.$value, $tabeName.'.'.$key)
            ->all();
    }

    public function salesAssociateManagers($key = 'id', $value = 'name')
    {
        $tabeName = User::getTableName();
        return User::salesAssociates()->orderBy($tabeName.'.'.$value)->pluck($tabeName.'.'.$value, $tabeName.'.'.$key)
            ->all();
    }

    public function getUsersNotRolePaginate($paginate = 25)
    {
        return User::with('profile')->notRoles()->paginate($paginate);
    }

    public function mapProjectManagers()
    {
        $tabeName = User::getTableName();

        $users = User::projectManagers()
            ->with('profile', 'order')
            ->orderBy($tabeName.'.name')
            ->get();

        return $users
            ->where('order.active', 1)
            ->mapWithKeys(function ($user) {
                $profile = $user->profile;
                return [$user['id'] => $profile['firstname'].' '.$profile['lastname']];
            })
            ->all();
    }

    public function mapSalesAssociates()
    {
        $tabeName = User::getTableName();

        $users = User::salesAssociates()
            ->with('profile', 'order')
            ->orderBy($tabeName.'.name')
            ->get();

        return $users
            ->where('order.active', 1)
            ->mapWithKeys(function ($user) {
                $profile = $user->profile;
                return [$user['id'] => $profile['firstname'].' '.$profile['lastname']];
            })
            ->all();
    }

    public function pluckCustomers($key = 'id', $value = 'name')
    {
        $tabeName = User::getTableName();
        return User::customers()->pluck($tabeName.'.'.$value, $tabeName.'.'.$key)
            ->all();
    }

    public function mapCustomers()
    {
        $tabeName = User::getTableName();
        $users = User::customers()
            ->with('profile')
            ->orderBy($tabeName.'.name')
            ->get();

        return $users->mapWithKeys(function ($user) {
                $profile = $user->profile;
                return [$user['id'] => $profile['firstname'].' '.$profile['lastname']];
            })
            ->all();
    }

    public function pluckContractors($key = 'id', $value = 'name')
    {
        $tabeName = User::getTableName();
        return User::contractors()->pluck($tabeName.'.'.$value, $tabeName.'.'.$key)
            ->all();
    }

    public function mapContractors()
    {
        $tabeName = User::getTableName();
        $users = User::contractors()
            ->with('profile')
            ->orderBy($tabeName.'.name')
            ->get();

        return $users->mapWithKeys(function ($user) {
                $profile = $user->profile;
                return [$user['id'] => $profile['firstname'].' '.$profile['lastname']];
            })
            ->all();
    }

    public function mapBindUsers()
    {
        $tabeName = User::getTableName();
        $users = User::contractors()
            ->with('profile')
            ->orderBy($tabeName.'.name')
            ->get();

        return $users->mapWithKeys(function ($user) {
                $profile = $user->profile;
                return [$user['id'] => $profile['firstname'].' '.$profile['lastname']];
            })
            ->all();
    }

    public function createNewUser($fields)
    {
        return User::create([
            'name' => $fields['firstname'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'password' => (isset($fields['password']) && $fields['password'])?bcrypt($fields['password']):null,
        ]);
    }

    public function createNewProfile($userId, $fields)
    {
        return Profile::create([
            'user_id' => $userId,
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email'],
            'street_address1' => $fields['street_address1'],
            'street_address2' => $fields['street_address2'],
            'city' => $fields['city'],
            'state' => $fields['state'],
            'postal_code' => $fields['postal_code'],
            'source_id' => $fields['source'],
            'note' => $fields['note'],
        ]);
    }

    public function createNewOrder($userId, $fields)
    {
        return Order::create([
            'user_id' => $userId,
            'project_type_id' => (bool) $fields['project_type']?$fields['project_type']:null,
            'project_manager_id' => (bool) $fields['project_manager']?$fields['project_manager']:null,
            'status' => $fields['status'],
        ]);
    }

    public function updateUser(User $user, $fields)
    {
        $user->email = $fields['email'];
        $user->name = $fields['firstname'];
        $user->phone = $fields['phone'];
        return $user->save();
    }

    public function updateProfileCustomer(User $user, $fields)
    {
        $profile = $user->profile;
        $profile->firstname = $fields['firstname'];
        $profile->lastname = $fields['lastname'];
        $profile->email = $fields['email'];
        $profile->street_address1 = $fields['street_address1'];
        $profile->street_address2 = $fields['street_address2'];
        $profile->city = $fields['city'];
        $profile->state = $fields['state'];
        $profile->postal_code = $fields['postal_code'];
        $profile->source_id = $fields['source'];
        $profile->note = $fields['note'];
        return $profile->save();
    }

    public function updateOrderCustomer(User $user, $fields)
    {
        $orders = $user->orders->first();
        $orders->project_type_id = (bool) $fields['project_type']?$fields['project_type']:null;
        $orders->project_manager_id = (bool) $fields['project_manager']?$fields['project_manager']:null;
        $orders->status = $fields['status'];
        return $orders->save();
    }

    public function createNewVendorProfile($userId, $fields)
    {
        return Profile::create([
            'user_id' => $userId,
            'company' => $fields['company'],
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email'],
            'street_address1' => $fields['street_address1'],
            'street_address2' => $fields['street_address2'],
            'city' => $fields['city'],
            'state' => $fields['state'],
            'postal_code' => $fields['postal_code'],
            'website' => $fields['website'],
            'fax_number' => $fields['fax_number'],
            'note' => $fields['note'],
        ]);
    }

    public function updateProfileVendor(User $user, $fields)
    {
        $profile = $user->profile;
        $profile->company = $fields['company'];
        $profile->firstname = $fields['firstname'];
        $profile->lastname = $fields['lastname'];
        $profile->email = $fields['email'];
        $profile->street_address1 = $fields['street_address1'];
        $profile->street_address2 = $fields['street_address2'];
        $profile->city = $fields['city'];
        $profile->state = $fields['state'];
        $profile->postal_code = $fields['postal_code'];
        $profile->website = $fields['website'];
        $profile->fax_number = $fields['fax_number'];
        $profile->note = $fields['note'];
        return $profile->save();
    }

    public function createNewContractorProfile($userId, $fields)
    {
        return Profile::create([
            'user_id' => $userId,
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email'],
            'street_address1' => $fields['street_address1'],
            'street_address2' => $fields['street_address2'],
            'city' => $fields['city'],
            'state' => $fields['state'],
            'postal_code' => $fields['postal_code'],
            'note' => $fields['note'],
        ]);
    }

    public function updateProfileContractor(User $user, $fields)
    {
        $profile = $user->profile;
        $profile->firstname = $fields['firstname'];
        $profile->lastname = $fields['lastname'];
        $profile->email = $fields['email'];
        $profile->street_address1 = $fields['street_address1'];
        $profile->street_address2 = $fields['street_address2'];
        $profile->city = $fields['city'];
        $profile->state = $fields['state'];
        $profile->postal_code = $fields['postal_code'];
        $profile->note = $fields['note'];
        return $profile->save();
    }

    public function createNewProjectManagerProfile($userId, $fields)
    {
        return Profile::create([
            'user_id' => $userId,
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email'],
            'street_address1' => $fields['street_address1'],
            'street_address2' => $fields['street_address2'],
            'city' => $fields['city'],
            'state' => $fields['state'],
            'postal_code' => $fields['postal_code'],
            'note' => $fields['note'],
        ]);
    }

    public function createNewProjectManagerOrder($userId, $fields)
    {
        return Order::create([
            'user_id' => $userId,
            'active' => $fields['active'],
        ]);
    }

    public function updateProfileProjectManager(User $user, $fields)
    {
        $profile = $user->profile;
        $profile->firstname = $fields['firstname'];
        $profile->lastname = $fields['lastname'];
        $profile->email = $fields['email'];
        $profile->street_address1 = $fields['street_address1'];
        $profile->street_address2 = $fields['street_address2'];
        $profile->city = $fields['city'];
        $profile->state = $fields['state'];
        $profile->postal_code = $fields['postal_code'];
        $profile->note = $fields['note'];
        return $profile->save();
    }

    public function updateOrderProjectManager(User $user, $fields)
    {
        $orders = $user->orders->first();
        $orders->active = $fields['active'];
        return $orders->save();
    }

    public function createNewSalesAssociateProfile($userId, $fields)
    {
        return Profile::create([
            'user_id' => $userId,
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email'],
            'street_address1' => $fields['street_address1'],
            'street_address2' => $fields['street_address2'],
            'city' => $fields['city'],
            'state' => $fields['state'],
            'postal_code' => $fields['postal_code'],
            'note' => $fields['note'],
        ]);
    }

    public function createNewSalesAssociateOrder($userId, $fields)
    {
        return Order::create([
            'user_id' => $userId,
            'active' => $fields['active'],
        ]);
    }

    public function updateProfileSalesAssociate(User $user, $fields)
    {
        $profile = $user->profile;
        $profile->firstname = $fields['firstname'];
        $profile->lastname = $fields['lastname'];
        $profile->email = $fields['email'];
        $profile->street_address1 = $fields['street_address1'];
        $profile->street_address2 = $fields['street_address2'];
        $profile->city = $fields['city'];
        $profile->state = $fields['state'];
        $profile->postal_code = $fields['postal_code'];
        $profile->note = $fields['note'];
        return $profile->save();
    }

    public function updateOrderSalesAssociate(User $user, $fields)
    {
        $orders = $user->orders->first();
        $orders->active = $fields['active'];
        return $orders->save();
    }

    public function getActiveLastPriced(User $user) {
        return $user->priceds()
            ->whereDate('user_priceds.end_date', '>', Carbon::today())
            ->orderBy('user_priceds.updated_at', 'DESC')
            ->first();
    }

    public function createNewEmptyProfile(User $user)
    {
        $user->profile()->create([
            'firstname' => '',
            'lastname' => '',
            'email' => $user->email,
            'street_address1' => '',
            'street_address2' => '',
            'city' => '',
            'state' => '',
            'postal_code' => '',
            'note' => '',
        ]);
        $user->load('profile');
        return $user;
    }

    public function createNewEmptyOrder(User $user)
    {
        $user->orders()->create([
            'project_type_id' => null,
            'project_manager_id' => null,
            'status' => null,
        ]);
        $user->load('orders');
        return $user;
    }
}