<?php

/**
 * @Copyright (c) 2011 51zx Inc.
 * @author        gaoshikao@qq.com
 * @date          2014-10-06
 *
 * 表单验证
 */

class Validate{

    //验证手机号码
    public static function checkMobile($mobile){
        return preg_match('/^1[34578]{1}\d{9}$/', $mobile) === 1;
    }
}