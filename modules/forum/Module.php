<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/3
 * Time: 16:09
 */

namespace app\modules\forum;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        $this->params['foo'] = 'bar';
        // ...  其他初始化代码 ...
    }
}