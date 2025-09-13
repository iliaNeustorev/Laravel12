<?php

namespace Tests\Mocks;

use App\Enums\System\Roles;
use App\Interfaces\SystemHelperInterface;
use App\Models\User;

class MockSystemHelper implements SystemHelperInterface
{
    /**
     *
     * @param User $user
     * @return array
     */
    public function getRolesUserFromCache(User $user): array
    {
        return [Roles::DEVELOPER];
    }

    /**
     *
     * @param User $user
     * @return array
     */
    public function saveRolesUserInCache(User $user): array
    {
       return [Roles::DEVELOPER];
    }
}