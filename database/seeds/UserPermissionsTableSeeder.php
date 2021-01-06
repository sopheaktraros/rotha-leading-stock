<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPermissionsTableSeeder extends Seeder {
    public function getPermissions() {
        return [
            ['id'=>1,'name'=>'security','label'=>'Security','read'=>0,'write'=>0,'delete'=>0],
            ['id'=>2,'name'=>'settings','label'=>'Settings','read'=>0,'write'=>0,'delete'=>0],

            //Settings
            ['id'=>3,'name'=>'general','label'=>'General','parent'=>2],

            //Security
            ['id'=>4,'name'=>'users','label'=>'Users','parent'=>1],
            ['id'=>5,'name'=>'roles','label'=>'Roles','parent'=>1],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $permissions = $this->getPermissions();

        foreach ( $permissions as $permission ) {
            DB::table( 'user_permissions' )->insert( [
                'name' => $permission['name'],
                'label' => $permission['label'],
                'read' => isset($permission['read']) ? $permission['read'] : 1,
                'write' => isset($permission['write']) ? $permission['write'] : 1,
                'delete' => isset($permission['delete']) ? $permission['delete'] : 1,
                'parent' => isset($permission['parent']) ? $permission['parent'] : NULL,
            ] );
        }
    }
}
