<?php
namespace App\Repositories\Admin\Menu;
use App\Models\Menu;
use App\Models\Help;
use Illuminate\Support\Facades\DB;

class MenuRepository implements MenuRepositoryContract{

    const MENU_ROLE_TB = 'menu_role';

    public function create($requestData)
    {

        return Menu::create($requestData);

    }

    public function getAllMenu($flag = true)
    {
        $menus = $flag ? Menu::all()->toArray() : Menu::where(['display' => 1])->get()->toArray();

        foreach ($menus as $val)
            $items[$val['id']] = $val;

        return $items ? Help::generateTree($items) : false;
    }

    public function getListMenu($id = false)
    {
        $listMenus =  $id ? Menu::find($id): Menu::paginate(5);


        foreach ($listMenus as &$val){

            $loop = $id ? $listMenus :$val;
            $loop->pid && ($loop->pname = Menu::where('id', $loop->pid)->value('name'));
        }

        return $listMenus;
    }


    public function update($id, $data)
    {
        return Menu::where(['id' => $id])->update($data);
    }

    public function destroy($id)
    {
        //首先判断该菜单是否有子菜单 若有要删除子菜单
        $idArr = Menu::where(['pid' => $id])->pluck('id')->toArray();

        if($idArr){

            array_push($idArr, $id);

            $menuDelRes = Menu::destroy($idArr);

            $menuRoleDelRes = DB::table(self::MENU_ROLE_TB)->whereIn('menu_id', $idArr)->delete();

        }else{

            $menuDelRes = $menuDelRes =  Menu::destroy($id);

            $menuRoleDelRes = DB::table(self::MENU_ROLE_TB)->whereIn('menu_id', [$id])->delete();
        }

        return ($menuDelRes >=0 && $menuRoleDelRes !== false) ? true : false;

    }

}