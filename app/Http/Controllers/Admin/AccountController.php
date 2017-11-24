<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Account\AccountRepositoryContract;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{

    protected $account;

    public function __construct( AccountRepositoryContract $accounts) {

        $this->account =   $accounts;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.accounts.index',[
            'pageData' => $this->account->getListAccount(),
            'roles' => $this->account->getAllRole(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $postData = json_decode($request->data, true);

        $checkboxId = $request->eid ? $request->idarr : array_keys($postData,'on');

        $roleId = array_map(function ($arr){return str_replace('role_', '', $arr);}, $checkboxId);

        if(!$request->eid){
            $this->validate($request, [
                'uname' => [
                    'required',
                    Rule::unique('admins', 'uname')->ignore($request->eid)
                ],
            ]);

            $data = [
                'uname' => $postData['uname'],
                'nickname' => trim($postData['name']),
                'password' => password_hash(trim($postData['pwd']), PASSWORD_BCRYPT),
                'reg_time' => date('Y-m-d H:i:s',time()),
                'operator' => 1,
            ];

            $menuRes = $this->account->create($data, $roleId);
        }else{

            $data = [
                'nickname' =>  trim($postData['name']),
                'operator' => 1,
            ];

            $menuRes = $this->account->update($request->eid, $data, $roleId);

        }

        return $menuRes ?
            response()->json(['status' => 1, 'msg' => '操作成功']):
            response()->json(['status' => 0, 'msg' => '操作失败,请稍后重试']);
    }

    public function find(Request $request){

        return response()->json($this->account->find($request->id));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->account->destroy($request->id) ? response()->json(['status' => 1, 'msg' => '删除成功']):
            response()->json(['status' => 0, 'msg' => '删除失败,请稍后重试']);
    }
}
