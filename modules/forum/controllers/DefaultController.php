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
        $fieldSeparator = ',';
        header('Content-Disposition:attachment;filename="fdfds.csv"');
        header('Cache-Control:no-cache');
        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
        echo "\"fdsfds\"{$fieldSeparator}";
        exit();


        $str = "http:/blog.csdn.net/zyu67/article/details/42295681";
        $str = str_replace("http://","",$str);
        echo $str;die;




        $array = 'fdsfds';
        $function['aaa'] = function($ayy) use($array){
            echo <<<abc
            $array; $ayy
abc;

        };
        $function['aaa']("dsd");die;
        //return $this->render('index');
       $myException = function ($exception)
       {
           echo "<b>Exception:</b> " , $exception->getMessage();
       } ;

        set_exception_handler($myException);

        //throw new \Exception();


        header('Access-Control-Allow-Origin:*');
        echo  gmdate('D, d M Y H:i:s') . ' GMT';die;
        return $this->render('index');

        echo md5(sha1(123456) . 'xlhibapKW/V1L{r>!F7=XYn#RsfMJ%]6<(IG0?U-');die;

        //phpinfo();
       //var_dump(in_array([0=>"1"],['2',['1'],'4']));die;

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

    }

}