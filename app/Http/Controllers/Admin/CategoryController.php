<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Repositories\Admin\Category\CategoryRepositoryContract;
use App\Models\Help;

class CategoryController extends Controller
{

    const CATE_SHOW_PATH = 'categorys';

    protected $category;

    protected $type = ['首页分类', '其他分类'];

    public function __construct(
        CategoryRepositoryContract $categorys
    ) {

        $this->category = $categorys;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('admin.categorys.index',[
            'pageData' => $this->category->getListCategory(),
            'types' => $this->type
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'required',
                Rule::unique('categorys')->ignore($request->eid)
            ],
        ]);

        $data = [
            'name' => $request->name,
            'sort' => $request->categorysort?:0,
            'display' => $request->categoryshow,
            'type' => $request->categorystype,
            'cover_show' => $request->categorysimg,
            'operator' => 1,
        ];

        $menuRes = $request->eid ?
            $this->category->update($request->eid, $data):
            $this->category->create($data);

        return $menuRes ?
            response()->json(['status' => 1, 'msg' => '操作成功']):
            response()->json(['status' => 0, 'msg' => '操作失败,请稍后重试']);
    }

    public function upload(Request $request)
    {

        return response()->json(Help::upload(

            $request->file($request->iptname),

            self::CATE_SHOW_PATH,

            $request->idtag
        ));
    }

    public function find(Request $request){

        return response()->json($this->category->find($request->id));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->category->destroy($request->id) ? response()->json(['status' => 1, 'msg' => '删除成功']):
            response()->json(['status' => 0, 'msg' => '删除失败,请稍后重试']);
    }
}
