<?php
namespace App\Repositories\Admin\Category;

use App\Models\Category;
use App\Models\Help;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryContract{

    public function create($requestData)
    {

        return Category::create($requestData);

    }

    public function getListCategory()
    {
        return Category::paginate(5);
    }

    public function find($id){

        return Category::find($id);

    }

    public function update($id, $data)
    {
        return Category::where(['id' => $id])->update($data);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        return ($category->delete() && $category->products()->detach()) ? true :false;
    }

}