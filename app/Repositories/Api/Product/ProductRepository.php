<?php
namespace App\Repositories\Admin\Product;

use App\Models\Cover;
use App\Models\Product;
use App\Models\Category;
use App\Models\Help;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryContract{

    public function create($requestData, $cateId)
    {

        return Product::create($requestData)->categorys()->attach($cateId) == null ? true :false;

    }

    public function getAllCategory()
    {
        return Category::all();
    }

    public function getListProduct(){

        return Product::orderBy('sort', 'desc')->paginate(5);
    }

    public function find($id){

        $product = Product::find($id);

        return [
            'product'=>$product,//查找的商品
             'cateId' =>array_column(array_column($product->categorys->toArray(), 'pivot'),'category_id') //商品拥有的分类id
        ];

    }

    public function update($id, $data, $cateId)
    {
        return (Product::where(['id' => $id])->update($data) >= 0
            && Product::find($id)->categorys()->sync($cateId)) ? true :false;
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        return (($product->delete() && $product->categorys()->detach()) &&  Cover::where(['product_id' => $id])->delete())>=0 ? true :false;
    }

    public function createProductCover($id, $data){

        return Product::find($id)->covers()->createMany($data);
    }

    public function  getProductCover($id){

        return Product::find($id)->covers;

    }

    public function removeCover($id){

        return Cover::destroy($id)?:false;
    }

}