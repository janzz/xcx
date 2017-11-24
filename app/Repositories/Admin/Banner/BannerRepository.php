<?php
namespace App\Repositories\Admin\Banner;

use App\Models\Product;
use App\Models\Banner;

class BannerRepository implements BannerRepositoryContract{


    public function create($productId, $data)
    {

        return Product::find($productId)->banners()->create($data);

    }

    public function getAllProduct()
    {

        return Product::all();

    }

    public function getListBanner(){

        return Banner::orderBy('sort', 'desc')->paginate(5);
    }

    public function find($id){

        return ['banner' => Banner::find($id), 'product'=>Banner::find($id)->product];

    }

    public function update($id, $data)
    {
        return Banner::where(['id' => $id])->update($data);

    }

    public function destroy($id)
    {
        return Banner::destroy($id)?:false;
    }


}