<?php

namespace app\admin\controller;

use app\admin\model\Goods as GoodsModel;
use think\Request;
use think\Validate;

class Goods extends Base
{
    public function index()
    {
        // 查询列表页需要的数据
        // $list = GoodsModel::select();// 推荐使用select()
        // $list = GoodsModel::order('id desc')->paginate(3);
        // 接受keyword参数
        $keyword = input('keyword');
        $where   = [];
        if (!empty($keyword)) {
            $where['goods_name'] = ['like', "%$keyword%"];
        }
        // paginate的三个参数：每页数量 是否简介模式或总记录数 配置参数(query:url额外参数)
        $list = GoodsModel::where($where)->order('id desc')->paginate(3, false, [
            'query' => ['keyword', $keyword],
        ]);
        // 渲染模板
        return view('index', ['list' => $list]);
    }

    public function create(Request $request)
    {
        // 使用依赖注入的$request对象
        $data = $request->param();
        if ($data) {
            // 1. 定义验证规则
            $rules = [
                'goods_name'   => 'require',
                'goods_price'  => 'require|float|gt:0',
                'goods_number' => 'require|integer|gt:0',
            ];
            // 2. 定义错误提示
            $msg = [
                'goods_name.require'   => '商品名称不能为空',
                'goods_price.require'  => '商品价格不能为空',
                'goods_price.float'    => '商品价格格式不正确',
                'goods_price.gt'       => '商品价格必须大于0',
                'goods_number.require' => '商品数量不能为空',
                'goods_number.float'   => '商品数量格式不正确',
                'goods_number.gt'      => '商品数量必须大于0',
            ];
            // 3. 实例化验证器类 \think\Validate()
            $validate = new Validate($rules, $msg);
            // 4. 进行验证
            if (!$validate->check($data)) {
                // 验证失败，调用getError方法获取具体的错误提示
                $error = $validate->getError();
                $this->error($error);
            }
            // 使用静态create方法保存数据，第二个参数表示过滤非数据表中的字段
            $res = GoodsModel::create($data, true);
            if ($res) {
                $this->success('添加成功', 'index');
            } else {
                //错误页面的默认跳转页面是返回前一页，通常不需要设置
                $this->error('新增失败');
            }

        }
        return view();
    }

    public function edit($id)
    {
        $info = GoodsModel::find($id);
        return view('edit', ['info' => $info]);
    }

    public function update(Request $request, $id)
    {
        // 使用依赖注入的$request对象
        $data = $request->param();
        // 1. 定义验证规则
        $rules = [
            'goods_name'   => 'require',
            'goods_price'  => 'require|float|gt:0',
            'goods_number' => 'require|integer|gt:0',
        ];
        // 2. 定义错误提示
        $msg = [
            'goods_name.require'   => '商品名称不能为空',
            'goods_price.require'  => '商品价格不能为空',
            'goods_price.float'    => '商品价格格式不正确',
            'goods_price.gt'       => '商品价格必须大于0',
            'goods_number.require' => '商品数量不能为空',
            'goods_number.float'   => '商品数量格式不正确',
            'goods_number.gt'      => '商品数量必须大于0',
        ];
        // 3. 实例化验证器类 \think\Validate()
        $validate = new Validate($rules, $msg);
        // 4. 进行验证
        if (!$validate->check($data)) {
            // 验证失败，调用getError方法获取具体的错误提示
            $error = $validate->getError();
            $this->error($error);
        }
        // 修改数据
        GoodsModel::update($data, ['id' => $id], true);
        // 页面跳转
        $this->success('修改成功', 'index');
    }

    public function detail($id)
    {
        $goods = GoodsModel::find($id);
        return view('detail', ['goods' => $goods]);
    }

    public function delete($id)
    {
        if (!preg_match('/^\d+$/', $id)) {
            $this->error('参数错误');
        }
        // 软删除
        GoodsModel::destroy($id);
        $this->success('操作成功', 'index');
    }
}
