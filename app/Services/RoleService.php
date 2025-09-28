<?php

namespace App\Services;

use App\Constants\Role;
use App\Models\User;

class RoleService
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function isSuperAdmin()
    {
        return $this->user->role_id === Role::SUPER_ADMIN;
    }

    public function isUser()
    {
        return $this->user->role_id === Role::USER;
    }
}
