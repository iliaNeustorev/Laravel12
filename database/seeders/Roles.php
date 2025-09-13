<?php

namespace Database\Seeders;

use App\Models\Role as ModelsRole;
use Illuminate\Database\Seeder;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsRole::create(['name' => 'dev', 'description' => 'Разработчик']);
        ModelsRole::create(['name' => 'admin', 'description' => 'Администратор']);
        ModelsRole::create(['name' => 'author', 'description' => 'Автор']);
        ModelsRole::create(['name' => 'user', 'description' => 'Пользователь']);
    }
}
