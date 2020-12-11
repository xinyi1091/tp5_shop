<?php

namespace app\admin\controller;

use think\Controller;

class Login extends Controller
{
    // 登录
    public function login()
    {
        // 临时关闭当前模板的布局功能
        $this->view->engine->layout(false);
        return view();
    }
}
