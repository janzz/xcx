<?php
namespace App\Repositories\Admin\Menu;

interface MenuRepositoryContract{

    public function create($requestData);

    public function getAllMenu($flag = true);

    public function getListMenu($id = false);

    public function update($id, $data);

    public function destroy($id);

}