<?php

namespace app\api\controller;

class Index
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }

    // 模拟第三方接口
    public function testApi()
    {
        // 接收数据 id、name
        $params = input();
        // 处理数据 略
        // 返回数据
        return json(['code' => 200, 'msg' => 'success', 'data' => $params]);
    }

    // 模拟本地的方法，用来调用第三方接口
    public function testRequest()
    {
        // 接口地址
        $url = 'http://tp5.shop.me/api/index/testapi';

        // 发送get请求
        /*  $url .= '?id=100&page=10';
          // 发送请求
          $res = curl_request($url);
          dump($res);*/

        // post请求
        $params = ['id' => 100, 'page' => 10];
        $res    = curl_request($url, true, $params);
        dump($res);
    }

    /**
     * @desc http://tp5.shop.me/api/index/get_train_id_time/date/20201226/start_station_en/KMM/end_station_en/CCT/train_register_id/80000K22860Q
     * @param $date              string  日期
     * @param $start_station_en  string 出发车站名称_英文
     * @param $end_station_en    string 抵达车站名称_英文
     * @param $train_register_id string 中国铁路列车编号，如：5l000D314541
     */
    public function get_train_id_time($date, $start_station_en, $end_station_en, $train_register_id)
    {

        // 接口地址
        $url    = "http://itrain.market.alicloudapi.com/ai_market/ai_train/get_train_id_time";
        $method = "GET";
        //阿里云APPCODE
        $appcode = "fdbcd5758aeb4e94903fe27cc0c2fb41";
        $headers = [];
        array_push($headers, "Authorization:APPCODE " . $appcode);
        array_push($headers, "Content-Type:application/json; charset=utf-8");

        //参数配置
        $params       = [
            //日期，如：20180808
            'DATE'              => $date,
            //抵达车站名称_英文，如：CCT 长春
            'END_STATION_EN'    => $end_station_en,
            //出发车站名称_英文，如：昆明
            'START_STATION_EN'  => $start_station_en,
            //中国铁路列车编号，如：5l000D314541
            'TRAIN_REGISTER_ID' => $train_register_id,

        ];
        $paramsString = "?" . http_build_query($params);
        $url          = $url . $paramsString;
        // 发送请求
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);// 注意这一步
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if (1 == strpos("$" . $url, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $res = curl_exec($curl);
        // echo $res;die;
        //解析结果
        $arr = json_decode($res, true);
        //查询成功，展示信息
        $list = $arr['TRAIN_STATION_INFO_ENTITY'];
        echo '站序----站名----到站时间----出发时间----停留时间<br>';
        foreach ($list as $v) {
            echo $v['STATATON_ORDER_ID'], '----', $v['STATAION_CH'], '----', $v['TRAIN_ARRIVE_TIME'], '----', $v['TRAIN_START_TIME'], '----', $v['TRAIN_STOP_TIME'], '<br>';
        }
    }
}
