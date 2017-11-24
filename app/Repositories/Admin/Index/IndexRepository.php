<?php
namespace App\Repositories\Admin\Index;

use App\Models\Account;
use Illuminate\Support\Facades\DB;
use App\Models\Help;

class IndexRepository implements IndexRepositoryContract{

    const ADMIN_ROLE_TB = 'admin_role';
    const MENU_ROLE_TB = 'menu_role';
    const MENU_TB   = 'menus';
    const ROLE_TB   = 'roles';

    public function verifyUser($username)
    {
        return Account::where(['uname' => $username])->first()->toArray();

    }

    public function isAdmin(){

        return session('adminInfo.uname') == 'admin' ? true : false;

    }

    public function getUserMenu($uid){

        $menus =  DB::table(self::ADMIN_ROLE_TB)->distinct()
            ->join(self::MENU_ROLE_TB, self::ADMIN_ROLE_TB.'.role_id', '=', self::MENU_ROLE_TB.'.role_id')
            ->join(self::MENU_TB, self::MENU_ROLE_TB.'.menu_id', '=', 'menus.id')
            ->select(self::MENU_TB.'.*')
            ->where([self::ADMIN_ROLE_TB.'.admin_id' => $uid])
            ->get()->toArray();


        foreach ($menus as $val)

            $items[$val->id] = $val;

        return $items ? Help::generateTree(array_map('get_object_vars', $items)) : false;
    }


    public function getUserRole($id){

        foreach (Account::find($id)->roles as $role)

            $roleName[] = $role->role_name;

        return $roleName;
    }

    public function  getSessionAdminVal($field)
    {
        return session('adminInfo.'.$field);
    }

    public function  getUserRoute($uid)
    {
        return  DB::table(self::ADMIN_ROLE_TB)->distinct()
            ->join(self::MENU_ROLE_TB, self::ADMIN_ROLE_TB.'.role_id', '=', self::MENU_ROLE_TB.'.role_id')
            ->join(self::MENU_TB, self::MENU_ROLE_TB.'.menu_id', '=', 'menus.id')
            ->where([
                [ self::ADMIN_ROLE_TB.'.admin_id', '=',  $uid],
                [ self::MENU_TB.'.route', '<>',  '']
            ])->pluck('route')->toArray();

    }

    public function getAllRoute()
    {
        return DB::table(self::MENU_TB)->distinct()->where(self::MENU_TB.'.route', '<>',  '')->pluck('route')->toArray();
    }

}