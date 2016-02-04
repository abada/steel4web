<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class RoleTableSeeder
 */
class RoleTableSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        if (env('DB_CONNECTION') == 'mysql') {
            DB::table(config('access.roles_table'))->truncate();
        } elseif (env('DB_CONNECTION') == 'sqlite') {
            DB::statement('DELETE FROM ' . config('access.roles_table'));
        } else {
            //For PostgreSQL or anything else
            DB::statement('TRUNCATE TABLE ' . config('access.roles_table') . ' CASCADE');
        }

        //Administrador, id 1
        $role_model        = config('access.role');
        $admin             = new $role_model;
        $admin->name       = 'Administrator';
        $admin->all        = true;
        $admin->sort       = 1;
        $admin->created_at = Carbon::now();
        $admin->updated_at = Carbon::now();
        $admin->save();

        //Planejamento, id 2
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Planejamento';
        $user->sort       = 2;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        //Engenharia, id 3
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Engenharia';
        $user->sort       = 3;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        //PCP, id 4
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'PCP';
        $user->sort       = 4;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        //Apontador, id 5
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Apontador';
        $user->sort       = 5;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        //Lider de Produção, id 6
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Lider de Produção';
        $user->sort       = 6;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        //Gerencia Industrial, id 7
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Gerencia Industrial';
        $user->sort       = 7;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        //Expedição, id 8
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Expedição';
        $user->sort       = 8;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        //Almoxerifado, id 9
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Almoxerifado';
        $user->sort       = 9;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        //Qualidade, id 10
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Qualidade';
        $user->sort       = 10;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        //Montagem, id 11
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Montagem';
        $user->sort       = 11;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        //Gestão, id 12
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Gestão';
        $user->sort       = 12;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}