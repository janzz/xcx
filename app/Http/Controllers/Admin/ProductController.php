<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Help;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Product\ProductRepositoryContract;
use Illuminate\Validation\Rule;


class ProductController extends Controller
{


    protected $product;

    const COVER_SHOW_PATH = 'products/cover-show';

    const COVER_PATH = 'products/cover';


    public function __construct(ProductRepositoryContract $products) {

        $this->product =   $products;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.products.index',[
            'pageData' => $this->product->getListProduct(),
        ]);
    }

    public function find(Request $request)
    {

        $request->id && ($productData = $this->product->find($request->id));

        return View('admin.products.addproduct',['product' => $productData, 'categorys' => $this->product->getAllCategory()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //p($request);die;
        $postData = json_decode($request->data, true);

        //$checkboxId = $request->eid ? $request->idarr : array_keys($postData,'on');

        $cateId = array_map(function ($arr){return str_replace('cate_', '', $arr);}, array_keys($postData,'on'));

        $data = [
            'name' => $postData['name'], //名称
            'intro' => $postData['pintro']?:'', //介绍
            'sales_price' => $postData['psprice'], //销售价
            'market_price' => $postData['pmprice']?:0, //市场价
            'store' => $postData['pstore'],  //库存
            'weight' => $postData['pweight']?:0, //重量
            'sales_base' => $postData['psbase']?:0, //销售基数
            'details' => $postData['pdetails']?:'', //详情
            'sort' => $postData['sort']?:0, //排序
            'racking' => $postData['show'], //是否上架
            'cover_show' => $postData['pimgurl'], //封面图片
            'operator' => 1,
        ];

        $res = $postData['eid'] ?
            $this->product->update($postData['eid'], $data, $cateId):
            $this->product->create($data, $cateId);

        return $res ?
            response()->json(['status' => 1, 'msg' => '操作成功']):
            response()->json(['status' => 0, 'msg' => '操作失败,请稍后重试']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {

        return response()->json(Help::upload(

            $request->file($request->iptname),

            self::COVER_SHOW_PATH,

            $request->idtag
        ));
    }

    public function mulitUpload(Request $request)
    {
        p($request->iptname);die;

        if(!$request->iptname)return response()->json(['msg' => '请选择文件']);

        $tmp = [];

        array_walk(Help::upload(
            $request->file($request->iptname),
            self::COVER_PATH,
            $request->idtag
        ),
          function($val, $key) use(&$tmp){
                return $tmp[$key] = ['path' => $val];
        });


        return $this->product->createProductCover($request->idtag, $tmp) ?
            response()->json(['status' => 1, 'msg' => '操作成功']):
            response()->json(['status' => 0, 'msg' => '操作失败,请稍后重试']);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->product->destroy($request->id) ? response()->json(['status' => 1, 'msg' => '删除成功']):
            response()->json(['status' => 0, 'msg' => '删除失败,请稍后重试']);
    }

    public function cover(Request $request){
        return View('admin.products.cover',['product' => $this->product->find($request->id)]);
    }

    public  function preview(Request $request){
        return response()->json($this->product->getProductCover($request->id));
    }

    public function removeCover(Request $request){
        return $this->product->removeCover($request->id) ? response()->json(['status' => 1, 'msg' => '删除成功']):
            response()->json(['status' => 0, 'msg' => '删除失败,请稍后重试']);
    }

}
