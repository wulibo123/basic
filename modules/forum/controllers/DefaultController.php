<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/3
 * Time: 16:07
 */
namespace  app\modules\forum\controllers;

use yii\web\Controller;
use yii\data\Pagination;

class DefaultController extends Controller {
    public $layout = false;
    function actionIndex()
    {
        $function['aaa'] = function($array){
            echo <<<abc
            $array
abc;

        };
        $function['aaa']("你是我的眼");
        echo md5(md5("123456")."rLmSOu")."<br/>";
        $memcache = memcache_connect('localhost', 11211);
        if ($memcache){
            $memcache->set("str_key", "String to store in memcached");
            $memcache->set("num_key", 123);
            $array = Array('assoc'=>123, 345, 567);
            //next($array);
            //next($array);
            echo key($array)."-------------------".current($array)."<br>";
            $memcache->set("arr_key", $array);
            //输出下面三行表示配置成功
            echo var_dump($memcache->get('str_key')."成功了")."<br>";
            echo var_dump($memcache->get('num_key'))."<br>";
            echo var_dump($memcache->get('arr_key'))."<br>";
        }else{
            echo "Connection to memcached failed";   //输入这行表示没有配置成功
        }
        return $this->render('index');
    }

}