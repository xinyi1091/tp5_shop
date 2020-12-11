<?php

namespace app\home\controller;


use think\Controller;

class Index extends Controller
{
    public function index()
    {
        // // 模板变量赋值,需要继承Controller才能使用该方法
        // $this->assign('name', 'ThinkPHP');
        // $this->assign('email', 'thinkphp@qq.com');
        // // 或者批量赋值
        // $this->assign([
        //     'name'  => 'ThinkPHP',
        //     'email' => 'thinkphp@qq.com',
        // ]);
        // // 模板输出
        // return $this->fetch('index');

        // return $this->fetch('index', [
        //     'name'  => 'ThinkPHP',
        //     'email' => 'thinkphp@qq.com',
        // ]);

        return view('index', [
            'name'  => 'ThinkPHP',
            'email' => 'thinkphp@qq.com'
        ]);
    }
}
