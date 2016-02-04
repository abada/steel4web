<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class PermissionTableSeeder
 */
class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        if (env('DB_CONNECTION') == 'mysql') {
            DB::table(config('access.permissions_table'))->truncate();
            DB::table(config('access.permission_role_table'))->truncate();
            DB::table(config('access.permission_user_table'))->truncate();
        } elseif (env('DB_CONNECTION') == 'sqlite') {
            DB::statement('DELETE FROM ' . config('access.permissions_table'));
            DB::statement('DELETE FROM ' . config('access.permission_role_table'));
            DB::statement('DELETE FROM ' . config('access.permission_user_table'));
        } else {
            //For PostgreSQL or anything else
            DB::statement('TRUNCATE TABLE ' . config('access.permissions_table') . ' CASCADE');
            DB::statement('TRUNCATE TABLE ' . config('access.permission_role_table') . ' CASCADE');
            DB::statement('TRUNCATE TABLE ' . config('access.permission_user_table') . ' CASCADE');
        }

        /**
         * Don't need to assign any permissions to administrator because the all flag is set to true
         * in RoleTableSeeder.php
         */

        /**
         * Cadastros
         */
        //1 x 1
        $permission_model                = config('access.permission');
        $deletePermissions               = new $permission_model;
        $deletePermissions->name         = 'ver-cadastro';
        $deletePermissions->display_name = 'Ver Cadastros';
        $deletePermissions->system       = true;
        $deletePermissions->group_id     = 1;
        $deletePermissions->sort         = 1;
        $deletePermissions->created_at   = Carbon::now();
        $deletePermissions->updated_at   = Carbon::now();
        $deletePermissions->save();

        //2 x 3
        $permission_model                = config('access.permission');
        $deletePermissions               = new $permission_model;
        $deletePermissions->name         = 'criar-cadastro';
        $deletePermissions->display_name = 'Criar Cadastros';
        $deletePermissions->system       = true;
        $deletePermissions->group_id     = 1;
        $deletePermissions->sort         = 2;
        $deletePermissions->created_at   = Carbon::now();
        $deletePermissions->updated_at   = Carbon::now();
        $deletePermissions->save();

        //3 x 5
        $permission_model                = config('access.permission');
        $deletePermissions               = new $permission_model;
        $deletePermissions->name         = 'editar-cadastro';
        $deletePermissions->display_name = 'Editar Cadastros';
        $deletePermissions->system       = true;
        $deletePermissions->group_id     = 1;
        $deletePermissions->sort         = 3;
        $deletePermissions->created_at   = Carbon::now();
        $deletePermissions->updated_at   = Carbon::now();
        $deletePermissions->save();

        //4 x 7
        $permission_model                = config('access.permission');
        $deletePermissions               = new $permission_model;
        $deletePermissions->name         = 'deletar-cadastro';
        $deletePermissions->display_name = 'Deletar Cadastros';
        $deletePermissions->system       = true;
        $deletePermissions->group_id     = 1;
        $deletePermissions->sort         = 4;
        $deletePermissions->created_at   = Carbon::now();
        $deletePermissions->updated_at   = Carbon::now();
        $deletePermissions->save();

        //5 x 9
        $permission_model          = config('access.permission');
        $createUsers               = new $permission_model;
        $createUsers->name         = 'create-users';
        $createUsers->display_name = 'Criar Usuários';
        $createUsers->system       = true;
        $createUsers->group_id     = 1;
        $createUsers->sort         = 5;
        $createUsers->created_at   = Carbon::now();
        $createUsers->updated_at   = Carbon::now();
        $createUsers->save();

        //6 x 11
        $permission_model        = config('access.permission');
        $editUsers               = new $permission_model;
        $editUsers->name         = 'edit-users';
        $editUsers->display_name = 'Editar Usuários';
        $editUsers->system       = true;
        $editUsers->group_id     = 1;
        $editUsers->sort         = 6;
        $editUsers->created_at   = Carbon::now();
        $editUsers->updated_at   = Carbon::now();
        $editUsers->save();

        //7 x 13
        $permission_model          = config('access.permission');
        $deleteUsers               = new $permission_model;
        $deleteUsers->name         = 'delete-users';
        $deleteUsers->display_name = 'Deletar Usuários';
        $deleteUsers->system       = true;
        $deleteUsers->group_id     = 1;
        $deleteUsers->sort         = 7;
        $deleteUsers->created_at   = Carbon::now();
        $deleteUsers->updated_at   = Carbon::now();
        $deleteUsers->save();

        //8 x 15
        $permission_model                 = config('access.permission');
        $changeUserPassword               = new $permission_model;
        $changeUserPassword->name         = 'change-user-password';
        $changeUserPassword->display_name = 'Mudar Senha de  Usuários';
        $changeUserPassword->system       = true;
        $changeUserPassword->group_id     = 1;
        $changeUserPassword->sort         = 8;
        $changeUserPassword->created_at   = Carbon::now();
        $changeUserPassword->updated_at   = Carbon::now();
        $changeUserPassword->save();

        //9 x 17
        $permission_model             = config('access.permission');
        $deactivateUser               = new $permission_model;
        $deactivateUser->name         = 'deactivate-users';
        $deactivateUser->display_name = 'Desativar Usuários';
        $deactivateUser->system       = true;
        $deactivateUser->group_id     = 1;
        $deactivateUser->sort         = 9;
        $deactivateUser->created_at   = Carbon::now();
        $deactivateUser->updated_at   = Carbon::now();
        $deactivateUser->save();

        //10 x 19
        $permission_model             = config('access.permission');
        $reactivateUser               = new $permission_model;
        $reactivateUser->name         = 'reactivate-users';
        $reactivateUser->display_name = 'Re-Ativar Usuários';
        $reactivateUser->system       = true;
        $reactivateUser->group_id     = 1;
        $reactivateUser->sort         = 10;
        $reactivateUser->created_at   = Carbon::now();
        $reactivateUser->updated_at   = Carbon::now();
        $reactivateUser->save();

        //11 x 21
        $permission_model                    = config('access.permission');
        $permanentlyDeleteUser               = new $permission_model;
        $permanentlyDeleteUser->name         = 'permanently-delete-users';
        $permanentlyDeleteUser->display_name = 'Deletar Usuários';
        $permanentlyDeleteUser->system       = true;
        $permanentlyDeleteUser->group_id     = 1;
        $permanentlyDeleteUser->sort         = 11;
        $permanentlyDeleteUser->created_at   = Carbon::now();
        $permanentlyDeleteUser->updated_at   = Carbon::now();
        $permanentlyDeleteUser->save();
        /**
         * Importador
         */

        //12 x 23
        $permission_model                = config('access.permission');
        $deletePermissions               = new $permission_model;
        $deletePermissions->name         = 'visualizar-importador';
        $deletePermissions->display_name = 'Visualizar Importador';
        $deletePermissions->system       = true;
        $deletePermissions->group_id     = 1;
        $deletePermissions->sort         = 12;
        $deletePermissions->created_at   = Carbon::now();
        $deletePermissions->updated_at   = Carbon::now();
        $deletePermissions->save();

        //13 x 25
        $permission_model                = config('access.permission');
        $deletePermissions               = new $permission_model;
        $deletePermissions->name         = 'criar-importacao';
        $deletePermissions->display_name = 'Criar Importador';
        $deletePermissions->system       = true;
        $deletePermissions->group_id     = 1;
        $deletePermissions->sort         = 13;
        $deletePermissions->created_at   = Carbon::now();
        $deletePermissions->updated_at   = Carbon::now();
        $deletePermissions->save();

        //14  x 27
        $permission_model                = config('access.permission');
        $deletePermissions               = new $permission_model;
        $deletePermissions->name         = 'deletar-importacao';
        $deletePermissions->display_name = 'Deletar Importação';
        $deletePermissions->system       = true;
        $deletePermissions->group_id     = 1;
        $deletePermissions->sort         = 14;
        $deletePermissions->created_at   = Carbon::now();
        $deletePermissions->updated_at   = Carbon::now();
        $deletePermissions->save();
        /**
         * Apontador
         */

        //15 x 29
        $permission_model                = config('access.permission');
        $deletePermissions               = new $permission_model;
        $deletePermissions->name         = 'visualizar-apontador';
        $deletePermissions->display_name = 'Visualizar Apontador';
        $deletePermissions->system       = true;
        $deletePermissions->group_id     = 1;
        $deletePermissions->sort         = 15;
        $deletePermissions->created_at   = Carbon::now();
        $deletePermissions->updated_at   = Carbon::now();
        $deletePermissions->save();

        //16 x 31
        $permission_model                = config('access.permission');
        $deletePermissions               = new $permission_model;
        $deletePermissions->name         = 'criar-apontacao';
        $deletePermissions->display_name = 'Criar Apontação';
        $deletePermissions->system       = true;
        $deletePermissions->group_id     = 1;
        $deletePermissions->sort         = 16;
        $deletePermissions->created_at   = Carbon::now();
        $deletePermissions->updated_at   = Carbon::now();
        $deletePermissions->save();
        /**
         * Gestor de Lotes
         */

        //17 x 33
        $permission_model                = config('access.permission');
        $deletePermissions               = new $permission_model;
        $deletePermissions->name         = 'visualizar-gestor';
        $deletePermissions->display_name = 'Visualizar Gestor de Lotes';
        $deletePermissions->system       = true;
        $deletePermissions->group_id     = 1;
        $deletePermissions->sort         = 17;
        $deletePermissions->created_at   = Carbon::now();
        $deletePermissions->updated_at   = Carbon::now();
        $deletePermissions->save();
        
        //18 x 35
        $permission_model                = config('access.permission');
        $deletePermissions               = new $permission_model;
        $deletePermissions->name         = 'criar-lotes';
        $deletePermissions->display_name = 'Criar Lotes';
        $deletePermissions->system       = true;
        $deletePermissions->group_id     = 1;
        $deletePermissions->sort         = 18;
        $deletePermissions->created_at   = Carbon::now();
        $deletePermissions->updated_at   = Carbon::now();
        $deletePermissions->save();

        //19 x 37
        $permission_model                = config('access.permission');
        $deletePermissions               = new $permission_model;
        $deletePermissions->name         = 'editar-lotes';
        $deletePermissions->display_name = 'Editar Lotes';
        $deletePermissions->system       = true;
        $deletePermissions->group_id     = 1;
        $deletePermissions->sort         = 19;
        $deletePermissions->created_at   = Carbon::now();
        $deletePermissions->updated_at   = Carbon::now();
        $deletePermissions->save();
       

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}