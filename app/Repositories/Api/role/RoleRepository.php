<?php
namespace App\Repositories\Admin\Role;
use App\Models\Role;

class RoleRepository implements RoleRepositoryContract{


    public function create($requestData, $menuId)
    {

        return Role::create($requestData)->menus()->attach(explode(',', rtrim($menuId, ','))) == null ? true :false;

    }

    public function update($id, $data, $menuId)
    {
        //更新 角色表 --- 更新角色、菜单关联表
        return (Role::where(['id' => $id])->update($data) >=0
               && Role::find($id)->menus()->sync(explode(',', rtrim($menuId, ',')))) ? true :false;
    }

    public function getListRole()
    {

        return Role::paginate(5);

    }

    public function find($id){

        $menuIdArr = [];

        $role = Role::find($id);

        foreach ($role->menus as $val)
            $menuIdArr['menu_id'][] = $val->pivot->menu_id;

        $menuIdArr['id'] = $id;
        $menuIdArr['role_name'] = $role->role_name;
        $menuIdArr['role_declare'] = $role->role_declare;


        return $menuIdArr;
    }

    public function destroy($id)
    {
        $role = Role::find($id);

        return ($role->delete() && $role->menus()->detach()) ? true :false;

    }
}