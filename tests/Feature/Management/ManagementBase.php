<?php

namespace Tests\Feature\Management;

use Hgs3\Models\User;
use Tests\TestCase;

abstract class ManagementBase extends TestCase
{
    /**
     * マネージャー権限のアカウントを取得
     *
     * @return User
     */
    protected function getManagerAccount(): User
    {
        return User::findByShowId('huckle');
    }
}