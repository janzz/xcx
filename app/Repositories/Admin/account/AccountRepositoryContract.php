<?php
namespace App\Repositories\Admin\Account;

interface AccountRepositoryContract{

    public function create($requestData, $roleId);

    public function update($id, $data, $roleId);

    public function getListAccount();

    public function getAllRole();

    public function find($id);

    public function destroy($id);


}