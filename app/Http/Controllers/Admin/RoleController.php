<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Menu\MenuRepositoryContract;
use App\Repositories\Admin\Role\RoleRepositoryContract;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{

    protected $menu;
    protected $role;

    public function __construct(
        MenuRepositoryContract $menus,
        RoleRepositoryContract $roles
    ){
        $this->menu =   $menus;
        $this->role =   $roles;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('admin.roles.index', ['pageData' => $this->role->getListRole()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->role_name){

            $this->validate($request, [
                'role_name' => [
                    'required',
                    Rule::unique('roles')->ignore($request->id)
                ],
            ]);

            $data = [
                'role_name' => $request->role_name,
                'role_declare' => $request-> roleDeclare?:'',
                'operator' => 1,
            ];

            $menuRes = $request->id ?
                $this->role->update($request->id, $data, $request->menuIdStr):
                $this->role->create($data, $request->menuIdStr);

            return $menuRes ?
                response()->json(['status' => 1, 'msg' => '操作成功']):
                response()->json(['status' => 0, 'msg' => '操作失败,请稍后重试']);
        }else{

            return View('admin.roles.addrole', [
                'menus' =>$this->menu->getAllMenu(false),
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request)
    {

        return View('admin.roles.addrole', [

            'menus' => $this->menu->getAllMenu(false),

            'roleData' => $this->role->find($request->id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->role->destroy($request->id) ? response()->json(['status' => 1, 'msg' => '删除成功']):
            response()->json(['status' => 0, 'msg' => '删除失败,请稍后重试']);

    }
}
