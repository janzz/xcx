<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Menu\MenuRepositoryContract;
use App\Repositories\Admin\Index\IndexRepositoryContract;
use Illuminate\Validation\Rule;
use App\Models\Menu;

class MenuController extends Controller
{

    protected $menu;
    protected $admin;

    public function __construct(
        MenuRepositoryContract $menus,
        IndexRepositoryContract $admins
    ) {

        $this->menu =   $menus;
        $this->admin =   $admins;

    }

    public function index(){

        //$this->authorizeForUser($this->admin->getLoginUser($this->admin->getSessionAdminVal('id')), 'view', Menu::class);
        return View('admin.menus.index', [
            'allMenus' =>$this->menu->getAllMenu(),
            'pageMenus'=>  $this->menu->getListMenu()
        ]);
    }

    public function store(Request $request){

        $this->validate($request, [
            'name' => [
                'required',
                 Rule::unique('menus')->ignore($request->menuid)
            ],
        ]);

        $data = [
            'pid' => $request-> menupid,
            'route' => $request-> menuroute?:'',
            'name' => $request-> name,
            'sort' => $request-> menusort?:0,
            'display' => $request-> menushow,
            'icon_class' => $request-> menuicon?:'',
            'operator' => 1,
        ];

        $menuRes = $request->menuid ?
            $this->menu->update($request->menuid, $data):
            $this->menu->create($data);

        return $menuRes ?
            response()->json(['status' => 1, 'msg' => '操作成功']):
            response()->json(['status' => 0, 'msg' => '操作失败,请稍后重试']);

    }


    public function find(Request $request){

        return response()->json($this->menu->getListMenu($request->id));

    }

    public function destroy(Request $request){

        return $this->menu->destroy($request->id) ? response()->json(['status' => 1, 'msg' => '删除成功']):
            response()->json(['status' => 0, 'msg' => '删除失败,请稍后重试']);


    }
}
