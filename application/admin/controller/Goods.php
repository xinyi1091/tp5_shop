<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Goods as GoodsModel;

class Goods extends Controller
{
    public function index()
    {
        // 查询列表页需要的数据
        $list = GoodsModel::select();// 推荐使用select()
        // 渲染模板
        return view('index', ['list' => $list]);
    }

    public function create()
    {
        return view();
    }

    public function edit()
    {
        return view();
    }

    public function detail($id)
    {
        $goods = GoodsModel::find($id);
        return view('detail', ['goods' => $goods]);
    }

    public function delete()
    {

    }
}
