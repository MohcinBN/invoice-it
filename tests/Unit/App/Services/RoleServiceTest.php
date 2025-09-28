<?php

namespace Tests\Unit\App\Services;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Test;
use App\Models\User;
use App\Constants\Role;
use App\Services\RoleService;

class RoleServiceTest extends TestCase
{
    private RoleService $superAdminService;
    private RoleService $userService;

    function setUp(): void
    {
        parent::setUp();

        $superAdmin = new User();
        $superAdmin->role_id = Role::SUPER_ADMIN;
        $this->superAdminService = new RoleService($superAdmin);

        $user = new User();
        $user->role_id = Role::USER;
        $this->userService = new RoleService($user);
    }
    
    #[Test]
    public function test_isSuperAdmin()
    {
        $this->assertTrue($this->superAdminService->isSuperAdmin());
    }

    #[Test]
    public function test_isUser()
    {
        $this->assertTrue($this->userService->isUser());
    }
}
