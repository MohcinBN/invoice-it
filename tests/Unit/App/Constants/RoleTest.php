<?php

namespace Tests\Unit\App\Constants;

use PHPUnit\Framework\TestCase;
use App\Constants\Role;
use PHPUnit\Framework\Test;

class RoleTest extends TestCase
{
    #[Test]
    public function test_role_constants()
    {
        $this->assertEquals(Role::SUPER_ADMIN, 'super_admin');
        $this->assertEquals(Role::USER, 'user');
    }
}
