<?php

namespace App\Services;

use Carbon\Carbon;
use App\Events\UserMail;
use App\Models\User\Role;
use App\Models\User\User;
use App\Models\User\Source;
use App\Models\User\Logging;
use Illuminate\Http\Request;
use App\Models\User\UserRole;
use App\Models\Billing\Priced;
use App\Models\User\UserPriced;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Repositories\User\UserRepository;
use App\Repositories\User\LoggingRepository;
use App\Repositories\Setting\SkillSpecialtyRepository;
use App\Repositories\Setting\MaterialServiceRepository;
use App\Repositories\Billing\PricedRepository;

class UserService
{
	protected $userRepository;
	protected $materialServiceRepository;
	protected $skillSpecialtyRepository;
	protected $loggingRepository;
	protected $pricedRepository;

    public function __construct(
        UserRepository $userRepository, 
        MaterialServiceRepository $materialServiceRepository, 
        SkillSpecialtyRepository $skillSpecialtyRepository,
        LoggingRepository $loggingRepository,
        PricedRepository $pricedRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->materialServiceRepository = $materialServiceRepository;
        $this->skillSpecialtyRepository = $skillSpecialtyRepository;
        $this->loggingRepository = $loggingRepository;
        $this->pricedRepository = $pricedRepository;
    }

    public function getAdminsPaginate($paginate = 25)
    {
        return $this->userRepository->getAdminsPaginate($paginate);
    }

    public function getContractorsPaginate($paginate = 25)
    {
        return $this->userRepository->getContractorsPaginate($paginate);
    }

    public function getSalesAssociatesPaginate($paginate = 25)
    {
        return $this->userRepository->getSalesAssociatesPaginate($paginate);
    }

    public function getCustomersPaginate($paginate = 25)
    {
        return $this->userRepository->getCustomersPaginate($paginate);
    }

    public function getProjectManagersPaginate($paginate = 25)
    {
        return $this->userRepository->getProjectManagersPaginate($paginate);
    }

    public function getVendorsPaginate($paginate = 25)
    {
        return $this->userRepository->getVendorsPaginate($paginate);
    }

    public function getUsersNotRolePaginate($paginate = 25)
    {
        return $this->userRepository->getUsersNotRolePaginate($paginate);
    }

    public function pluckListSources($key = 'id', $value = 'name')
    {
        return ['' => '-- Select Source --'] + Source::orderBy('name')->pluck($value, $key)
            ->all() + ['other' => 'Other'];
    }

    public function listSalesAssociate($default = true) {
        if ($default) {
            return ['' => '-- Select Sales Associate --'] + $this->userRepository->mapSalesAssociates();
        } else {
            return $this->userRepository->mapSalesAssociates();
        }
    }

    public function listProjectManager($default = true) {
        if ($default) {
            return ['' => '-- Select Project Manager --'] + $this->userRepository->mapProjectManagers();
        } else {
            return $this->userRepository->mapProjectManagers();
        }
    }

    public function pluckListCustomers($key = 'id', $value = 'name') {
        return ['' => '-- Select Customer --'] + $this->userRepository->pluckCustomers($key, $value);
    }

    public function mapListCustomers() {
        return ['' => '-- Select Customer --'] + $this->userRepository->mapCustomers();
    }

    public function pluckListContractors() {
        return $this->userRepository->pluckContractors();
    }

    public function mapListBindUsers() {
        return $this->userRepository->mapBindUsers();
    }

    public function createNewCustomer($fields) {
        $user = $this->userRepository->createNewUser($fields);

        if (!$user) {
            return false;
        }

        $user->is_blocked = 1;
        $user->save();

        if (
            !(
                $this->attachRoleForUser($user->id, Role::ROLE_CUSTOMER) 
                && $this->userRepository->createNewProfile($user->id, $fields)
                && $this->userRepository->createNewOrder($user->id, $fields)
            )
        ) {
            return false;
        }

        return $user;
    }

    public function updateCustomer(User $user, $fields) {
        
        $this->userRepository->updateUser($user, $fields);
        $this->userRepository->updateProfileCustomer($user, $fields);
        $this->userRepository->updateOrderCustomer($user, $fields);

        return true;
    }

    private function attachRoleForUser($userId, $roleName)
    {
        $role = Role::where('name', $roleName)
            ->first();

        if (!$role) {
            return false;
        }

        $role = UserRole::updateOrCreate([
            'user_id' => $userId,
        ], [
            'user_id' => $userId,
            'role_id' => $role->id,
        ]);

        if (!$role) {

            return false;
        }

        return true;
    }

    public function createNewVendor($fields) {
        $user = $this->userRepository->createNewUser($fields);

        if (!$user) {
            return false;
        }

        $user->is_blocked = 1;
        $user->save();

        if (
            !(
                $this->attachRoleForUser($user->id, Role::ROLE_VENDOR) 
                && $this->userRepository->createNewVendorProfile($user->id, $fields)
            )
        ) {
            return false;
        }

        if (isset($fields['material_service'])) {
            $fields['material_service'] = $this->materialServiceRepository->addNewMaterialService($fields['material_service']);    
            $this->materialServiceRepository->attachMaterialServiceForUser($user->id, $fields['material_service']);
        }

        return $user; 
    }

    public function updateVendor(User $user, $fields) {
        
        $this->userRepository->updateUser($user, $fields);
        $this->userRepository->updateProfileVendor($user, $fields);

        $this->materialServiceRepository->clearAttachUserMaterialService($user->id);
        if (isset($fields['material_service'])) {
            $fields['material_service'] = $this->materialServiceRepository->addNewMaterialService($fields['material_service']);    
            $this->materialServiceRepository->attachMaterialServiceForUser($user->id, $fields['material_service']);
        }

        return true;
    }

    public function createNewSalesAssociate($fields) {
        $user = $this->userRepository->createNewUser($fields);

        if (!$user) {
            return false;
        }

        $user->save();

        if (
            !(
                $this->attachRoleForUser($user->id, Role::ROLE_SALES_ASSOCIATE) 
                && $this->userRepository->createNewSalesAssociateProfile($user->id, $fields)
                && $this->userRepository->createNewSalesAssociateOrder($user->id, $fields)
            )
        ) {
            return false;
        }

        return $user;
    }

    public function updateSalesAssociate(User $user, $fields) {
        
        $this->userRepository->updateUser($user, $fields);
        $this->userRepository->updateProfileSalesAssociate($user, $fields);
        $this->userRepository->updateOrderSalesAssociate($user, $fields);

        return true;
    }
    
    public function createNewContractor($fields) {
        $user = $this->userRepository->createNewUser($fields);

        if (!$user) {
            return false;
        }

        $user->is_blocked = 1;
        $user->save();

        if (
            !(
                $this->attachRoleForUser($user->id, Role::ROLE_CONTRACTOR) 
                && $this->userRepository->createNewContractorProfile($user->id, $fields)
            )
        ) {
            return false;
        }

        if (isset($fields['skill_specialty'])) {
            $fields['skill_specialty'] = $this->skillSpecialtyRepository->addNewSkillSpecialty($fields['skill_specialty']);    
            $this->skillSpecialtyRepository->attachSkillSpecialtyForUser($user->id, $fields['skill_specialty']);
        }

        return $user;
    }

    public function updateContractor(User $user, $fields) {
        
        $this->userRepository->updateUser($user, $fields);
        $this->userRepository->updateProfileContractor($user, $fields);

        $this->skillSpecialtyRepository->clearAttachUserSkillSpecialty($user->id);
        if (isset($fields['skill_specialty'])) {
            $fields['skill_specialty'] = $this->skillSpecialtyRepository->addNewSkillSpecialty($fields['skill_specialty']);    
            $this->skillSpecialtyRepository->attachSkillSpecialtyForUser($user->id, $fields['skill_specialty']);
        }

        return true;
    }

    public function createNewProjectManager($fields) {
        $user = $this->userRepository->createNewUser($fields);

        if (!$user) {
            return false;
        }

        $user->save();

        if (
            !(
                $this->attachRoleForUser($user->id, Role::ROLE_PROJECT_MANAGER) 
                && $this->userRepository->createNewProjectManagerProfile($user->id, $fields)
                && $this->userRepository->createNewProjectManagerOrder($user->id, $fields)
            )
        ) {
            return false;
        }

        event(new UserMail($user, $fields));

        return $user;
    }

    public function updateProjectManager(User $user, $fields) {
        
        $this->userRepository->updateUser($user, $fields);
        $this->userRepository->updateProfileProjectManager($user, $fields);
        $this->userRepository->updateOrderProjectManager($user, $fields);

        return true;
    }

    public function createNewAdmin($fields) {
        $user = $this->userRepository->createNewUser($fields);

        if (!$user) {
            return false;
        }

        $user->is_admin = 1;
        $user->save();

        if (!($this->attachRoleForUser($user->id, Role::ROLE_ADMIN))) {
            return false;
        }

        return $user;
    }

    public function updateAdmin(User $user, $fields) {
        
        $this->userRepository->updateUser($user, $fields);

        return true;
    }

    public function createNewContact(Request $request) {
        $validatedData = $request->validate([
            'user_role' => 'required|in:customer,vendor,contractor,project-manager,sales-associate',
        ]);

        switch ($validatedData['user_role']) {
            case 'customer':
                $request = app('App\Http\Requests\User\CustomerCreateRequest');
                if ($this->createNewCustomer($request->all())) {
                    return 'customers';
                } else {
                    return false;
                }
            case 'vendor':
                $request = app('App\Http\Requests\User\VendorCreateRequest');
                if ($this->createNewVendor($request->all())) {
                    return 'vendors';
                } else {
                    return false;
                }
            case 'contractor':
                $request = app('App\Http\Requests\User\ContractorCreateRequest');
                if ($this->createNewContractor($request->all())) {
                    return 'contractors';
                } else {
                    return false;
                }
            case 'project-manager':
                $request = app('App\Http\Requests\User\ProjectManagerCreateRequest');
                if ($this->createNewProjectManager($request->all())) {
                    return 'project-managers';
                } else {
                    return false;
                }
            case 'sales-associate':
                $request = app('App\Http\Requests\User\SalesAssociateCreateRequest');
                if ($this->createNewSalesAssociate($request->all())) {
                    return 'sales-associates';
                } else {
                    return false;
                }
        }
        return false;
    }
    
    public function sendNewAccesses($user) {
        $result = event(new UserMail($user, []));

        return is_array($result)?$result[0]:$result;
    }

    public function getTypeCabinet() {
        $user = Auth::user();
        if ($user->roles->isEmpty()) return null;
        return $user->roles->first()->name;
    }

    public function getUserNewNotifications() {
        $user = Auth::user();
        return $user->unreadNotifications;
    }

    public function markViewed($notificationId) {
        $notification = Auth::user()
            ->notifications()
            ->findOrFail($notificationId);

        if ($notification) {
            $notification->markAsRead();
            return true;
        }

        return false;
    }

    public function markAllViewed() {
        Auth::user()
            ->unreadNotifications
            ->markAsRead();
    }

    public function insertInfoLogging(Request $request, $user) {
        if ($user->isContractor()) {
            $this->loggingRepository->insertInfoLogging($request, $user);
        }
    }

    public function updateInfoLogging(Request $request) {
        if (Auth::user()->isContractor()) {
            $logging = Logging::where('session_id', Session::getId())->first();
            if (!$logging) {
                $logging = Logging::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
                if ($logging && $logging->logout_user_time) {
                    $logging = $this->loggingRepository->insertInfoLogging($request, Auth::user());
                }
            }
            $this->loggingRepository->updateInfoLogging($request, $logging);
        }
    }

    public function subscribeDefault($user) {
        $priced = $this->pricedRepository->getDefault();

        if ($priced) {
            $this->pricedRepository->createSubscribe($user, $priced);
        }
    }

    public function isSendUserNotifyEmail($user) {
        return $this->pricedRepository->isSendUserNotifyEmail($user);
    }

    public function createNewEmptyProfile(User $user)
    {
        return $this->userRepository->createNewEmptyProfile($user);
    }

    public function createNewEmptyOrder(User $user)
    {
        return $this->userRepository->createNewEmptyOrder($user);
    }
}