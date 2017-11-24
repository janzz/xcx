<?php
namespace App\Repositories\Admin\Account;
use App\Models\Account;
use App\Models\Role;

class AccountRepository implements AccountRepositoryContract{


    public function create($requestData, $roleId)
    {

        return Account::create($requestData)->roles()->attach($roleId) == null ? true :false;

    }

    public function update($id, $data, $roleId)
    {
        //更新 角色表 --- 更新角色、菜单关联表
        return (Account::where(['id' => $id])->update($data) >= 0
               && Account::find($id)->roles()->sync($roleId)) ? true :false;

    }

    public function getListAccount()
    {

        return Account::paginate(5);

    }

    public function find($id){

        return ['account'=>Account::find($id), 'role' =>Account::find($id)->roles ];

    }

    public function destroy($id)
    {
        $account = Account::find($id);

        return ($account->delete() && $account->roles()->detach()) ? true :false;

    }

    public function  getAllRole()
    {
        return Role::all();
    }

}