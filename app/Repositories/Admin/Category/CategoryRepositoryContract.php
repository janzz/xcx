<?php
namespace App\Repositories\Admin\Category;

interface CategoryRepositoryContract{

    public function create($requestData);

    public function getListCategory();

    public function update($id, $data);

    public function find($id);

    public function destroy($id);

}