<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\Banner\BannerRepositoryContract;
use App\Models\Help;

class BannerController extends Controller
{
    const BANNER_PATH = 'banner';
    protected $banner;

    public function __construct( BannerRepositoryContract $banners) {

        $this->banner =   $banners;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.banners.index', [
            'products'=>$this->banner->getAllProduct(),
            'banners'=>$this->banner->getListBanner()
        ]);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $postData = json_decode($request->data, true);

        $data = [
            'title' => $postData['bannertitle'], //名称
            'path' => $postData['bannerpicurl'], //名称
            'sort' => $postData['bannersort']?:0, //排序
            'display' => $postData['show']?:0, //排序
            'operator' => 1,
        ];

        $postData['eid'] && $data['product_id'] = $postData['productid'];

        $res = $postData['eid'] ?
            $this->banner->update($postData['eid'], $data):
            $this->banner->create($postData['productid'], $data);

        return $res ?
            response()->json(['status' => 1, 'msg' => '操作成功']):
            response()->json(['status' => 0, 'msg' => '操作失败,请稍后重试']);
    }

    public function upload(Request $request)
    {

        return response()->json(Help::upload(

            $request->file($request->iptname),

            self::BANNER_PATH,

            $request->idtag
        ));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request)
    {
        return response()->json($this->banner->find($request->id));
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->banner->destroy($request->id) ? response()->json(['status' => 1, 'msg' => '删除成功']):
            response()->json(['status' => 0, 'msg' => '删除失败,请稍后重试']);
    }
}
