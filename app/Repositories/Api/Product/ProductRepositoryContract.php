<?php
namespace App\Repositories\Admin\Product;

interface ProductRepositoryContract{

    public function create($requestData, $cateId);

    public function getAllCategory();

    public function getListProduct();

    public function update($id, $requestData, $cateId);

    public function find($id);

    public function destroy($id);

    public function createProductCover($id, $data);

    public function getProductCover($id);

    public function removeCover($id);

}