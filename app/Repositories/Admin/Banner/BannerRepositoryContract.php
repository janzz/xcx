<?php
namespace App\Repositories\Admin\Banner;

interface BannerRepositoryContract{

    public function getAllProduct();

    public function getListBanner();

    public function create($id, $data);

    public function find($id);

    public function update($id, $data);

    public function destroy($id);


}