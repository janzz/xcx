<?php

namespace App\Models;

use Intervention\Image\ImageManagerStatic as Image;


class Help
{

    const UPLOAD_PATH = 'app/public/uploads/';//上传目录

    const LN_PATH =  'storage/uploads/'; //软连接->storage/app/public/uploads

    /**
     * @ Purpose:无限极分类
     * @param [] $items 排序后的菜单二维数组
     * e.g. $items = [
    1 => ['id' => 1, 'pid' => 0, 'name' => '安徽省'],
    2 => ['id' => 2, 'pid' => 0, 'name' => '浙江省'],
    3 => ['id' => 3, 'pid' => 1, 'name' => '合肥市'],
    4 => ['id' => 4, 'pid' => 3, 'name' => '长丰县'],
    5 => ['id' => 5, 'pid' => 1, 'name' => '安庆市'],
    ];
     * @return []
     */
    public static function generateTree($items)
    {
        foreach($items as $item)

            $items[$item['pid']]['son'][$item['id']] = &$items[$item['id']];

        return isset($items[0]['son']) ? $items[0]['son'] : [];
    }


    public static function  upload($resource, $dir, $id = false){

        $id && ( $dir = $dir.'/'.$id );

        $uploadDir = self::UPLOAD_PATH.$dir;//上传目录

        !is_dir(storage_path($uploadDir)) && mkdir(storage_path($uploadDir), 0777, true);

        if($id){ //多图

            foreach ($resource as $val)

                $imgLnPath[] = self::LN_PATH.$dir.'/'.self::uploadMethod($val, $uploadDir); //保存数据库的路径

            return $imgLnPath;

        }else{

            $imgLnPath = self::LN_PATH.$dir.'/'.self::uploadMethod($resource, $uploadDir);

            return ['saveUrl'=> $imgLnPath, 'imgUrl' => asset($imgLnPath)];//项目访问资源访问路径
        }

    }

    private  static  function uploadMethod($imgObj, $uploadDir){

        $fileName = rand(1000, 9999).time().'.'. $imgObj->getClientOriginalExtension();//文件名

        $uplodPath = storage_path($uploadDir.'/'.$fileName); //上传路径

        Image::make($imgObj->getRealPath())->save($uplodPath); //保存文件

        return $fileName;
    }

}
