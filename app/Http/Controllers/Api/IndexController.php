<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Api\Index\IndexRepositoryContract;

class IndexController extends Controller
{
    //


    protected $index;

    public function __construct(IndexRepositoryContract $indexs) {

        $this->index =   $indexs;
    }

    public function banner(){

        return response()->json($this->index->getBanner());
    }

    public function product(){

       return  response()->json($this->index->getHomeCategorysProducts());
    }

}
