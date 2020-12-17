<?php

namespace app\admin\controller;

use think\Controller;
use think\Validate;
use app\admin\model\Manager;

class Login extends Controller
{
    // 登录
    public function login()
    {
        // 助手函数
        if (request()->isPost()) {
            // post请求，表单提交
            $data = request()->param();
            // 验证规则 
            $rules = [
                'username' => 'require',
                'password' => 'require|length:6,16',
                // 'code|验证码' => 'require|captcha:login',
            ];
            $msg   = [
                'username.require' => '用户名不能为空',
                'password.require' => '用户密码不能为空',
                'password.length'  => '用户名密码长度必须在6-16个字符之间',
                // 'code.require'     => '验证码不能为空',
            ];
            // 实例化验证器类 \think\Validate()
            $validate = new Validate($rules, $msg);
            // 进行验证
            if (!$validate->check($data)) {
                // 验证失败，调用getError方法获取具体的错误提示
                $error = $validate->getError();
                $this->error($error);
            }
            // 校验验证码
            if (!captcha_check($data['code'], 'login')) {
                // 验证失败
                $this->error('验证码错误');
            }
            // 查询密码和用户名是否匹配
            $password = encrypt_password($data['password']);
            $where    = [
                'username' => $data['username'],
                'password' => $password,
            ];
            $user     = Manager::where($where)->find();
            if ($user) {
                // 匹配到
                session('manager_info', $user);
                // 页面跳转
                $this->success('登录成功', 'admin/index/index');
            } else {
                $this->error('用户名或密码错误');
            }
        }
        // 临时关闭当前模板的布局功能
        $this->view->engine->layout(false);
        return view();
    }

    // 登出
    public function logout()
    {
        // 清空所有session
        session(null);
        $this->redirect('admin/login/login');
    }
}
