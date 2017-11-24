<?php
namespace App\Repositories\Admin\Role;

interface RoleRepositoryContract{

    public function create($requestData, $menuId);

    public function update($id, $data, $menuId);

    public function getListRole();

    public function find($id);

    public function destroy($id);


}