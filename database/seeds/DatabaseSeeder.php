<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserGroupTableSeeder::class,
            UserPermissionsTableSeeder::class,
            UserRolesTableSeeder::class,
            UserPermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            SettingsTableSeeder::class,
            LocaleTableSeeder::class
        ]);
    }
}
