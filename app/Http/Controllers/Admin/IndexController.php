<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Index\IndexRepositoryContract;
use App\Repositories\Admin\Menu\MenuRepositoryContract;

class IndexController extends Controller
{
    //

    protected $admin;

    protected $menu;

    public function __construct(
        IndexRepositoryContract $indexs,
        MenuRepositoryContract $menus
    ) {

        $this->admin =   $indexs;
        $this->menu =   $menus;
    }

    public function index(){

        return view('admin.indexs.index');
    }

    public function main(){
        echo 1111;die;
    }


    public function login(){

        return view('admin.indexs.login');
    }

    public function verifyLogin(Request $request){
        // 获取没有查询字符串的当前的 URL ...


        $this->validate($request, [
            'uname' => 'required|max:50',
            'password' => 'required'
        ]);

        $userInfo = $this->admin->verifyUser($request->uname);

        if($userInfo && password_verify($request->password, $userInfo['password'])) {

            //用户信息
            session([ 'adminInfo' => $userInfo]);

            //用户菜单
            session([ 'menuInfo' => $this->admin->isAdmin()
                ? $this->menu->getAllMenu() : $this->admin->getUserMenu($this->admin->getSessionAdminVal('id'))]);

            //用户角色
            session(['adminRole' => $this->admin->getUserRole($this->admin->getSessionAdminVal('id'))]);

            return response()->json(['status' => 1, 'msg' => '登录成功']);

        }else{

            return response()->json(['status' => 0, 'msg' => '用户名或密码错误']);

        }

    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');

    }
}
