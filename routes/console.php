<?php

use App\Enums\System\Roles;
use App\Interfaces\SystemHelperInterface;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('test', function () {
    // $user = User::find(2);
    // $roles = Role::whereIn('name', [Roles::AUTHOR])->pluck('id')->toArray();
    // $roles = $user->roles()->sync($roles);
    // $systemHelper = app(SystemHelperInterface::class);
    // dd($systemHelper->saveRolesUserInCache($user));
})->purpose('ОК');
