<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    public function __construct(Request $request = null)
    {
        // 先实现父类的构造方法
        parent::__construct($request);
        // 登录检测
        if (!session('?manager_info')) {
            // 没有登录就跳转到登录页
            $this->redirect('admin/login/login');
        }
    }
}
