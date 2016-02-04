<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class PermissionGroupTableSeeder
 */
class PermissionGroupTableSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        if (env('DB_CONNECTION') == 'mysql') {
            DB::table(config('access.permission_group_table'))->truncate();
        } elseif (env('DB_CONNECTION') == 'sqlite') {
            DB::statement('DELETE FROM ' . config('access.permission_group_table'));
        } else {
            //For PostgreSQL or anything else
            DB::statement('TRUNCATE TABLE ' . config('access.permission_group_table') . ' CASCADE');
        }

        //id 1
        $group_model            = config('access.group');
        $permission             = new $group_model;
        $permission->name       = 'Geral';
        $permission->sort       = 1;
        $permission->created_at = Carbon::now();
        $permission->updated_at = Carbon::now();
        $permission->save();

    /*    //id 2
        $group_model            = config('access.group');
        $permission             = new $group_model;
        $permission->name       = 'Importador';
        $permission->sort       = 2;
        $permission->created_at = Carbon::now();
        $permission->updated_at = Carbon::now();
        $permission->save();

        //id 3
        $group_model            = config('access.group');
        $permission             = new $group_model;
        $permission->name       = 'Apontador';
        $permission->sort       = 3;
        $permission->created_at = Carbon::now();
        $permission->updated_at = Carbon::now();
        $permission->save();

        //id 4
        $group_model            = config('access.group');
        $permission             = new $group_model;
        $permission->name       = 'Gestor de Lotes';
        $permission->sort       = 4;
        $permission->created_at = Carbon::now();
        $permission->updated_at = Carbon::now();
        $permission->save(); */

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}