<?php
namespace App\Repositories\Api\Index;

use App\Models\Banner;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\Help;

class IndexRepository implements IndexRepositoryContract{

    const BANNER_NUM = 4;
    const CATE_NUM = 3;
    const PRODUCT_NUM = 4;

    public function getBanner()
    {

        $banner = Banner::where(['display' => 1])->orderBy('sort', 'desc')->limit(self::BANNER_NUM)->get();

        foreach ($banner as $val ) $val->path = asset($val->path);

        return $banner;

    }

    public function getHomeCategorysProducts()
    {

        $cates = Category::where(['type'=>1,'display' => 1])->orderBy('sort', 'desc')->limit(self::CATE_NUM)->get();

        $data = [];

        foreach($cates as $key => $cate){

            $data[$key]['id'] = $cate->id;
            $data[$key]['cate'] = $cate->name;

            $products = $cate->products()->where(['racking' => 1])->orderBy('sort', 'desc')->limit(self::PRODUCT_NUM)->get();

            foreach($products as $ke => $product){


                $product->cover_show = asset($product->cover_show);
                $data[$key]['product'][$ke] = $product->toArray();

            }


        };

        //echo "<Pre>";
        //print_r($data);die;

        return $data;

    }


}