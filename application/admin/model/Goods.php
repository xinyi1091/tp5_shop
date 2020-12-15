<?php

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Goods extends Model
{
    // 引入相关trait
    use SoftDelete;

    protected $deleteTime = 'delete_time';
}
