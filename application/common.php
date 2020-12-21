<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
if (!function_exists('encrypt_password')) {
    function encrypt_password($password)
    {
        // 盐值
        $salt = 'jdjsdluwoeuwn129';
        return md5(md5($password) . $salt);
    }
}


if (!function_exists('curl_request')) {
    // 使用curl发送请求
    function curl_request($url, $post = false, $params = [], $https = false)
    {
        // 使用curl_init 初始化请求会话
        $ch = curl_init($url);
        // 使用curl_setopt设置请求选项
        // post 需要单独设置，默认发送get请求
        if ($post) {
            // 设置POST请求
            curl_setopt($ch, CURLOPT_POST, true);
            // 设置请求参数
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        // 请求协议处理
        if ($https) {
            // 禁止从服务器验证本地客户端证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        // 使用curl_exec发送请求
        // 设置直接将返回参数通过curl_exec进行返回
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res        = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        if ($curl_errno > 0) {
            // 错误处理
            $curl_error = curl_error($ch);
            return ['code' => $curl_errno, 'msg' => $curl_error];
        }
        // 关闭请求
        curl_close($ch);
        return $res;
    }
}

