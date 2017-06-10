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
    public $defaultAction='selectall';
    public $layout = false;
    function actionIndex()
    {
        $pagination = new Pagination(['totalCount' => 100]);
        $number = 2;
        print($this->actionSelectall(1,2));

        try
        {
            if($number>1)
            {
                throw new \Exception("Value must be 1 or below");
            }
            // 如果抛出异常，以下文本不会输出
            echo '如果输出该内容，说明 $number 变量';
        } // 捕获异常
        catch(\Exception $e)
        {
            echo 'Message: ' .$e->getMessage();
        }
        return $this->render('index',['pagination'=>$pagination]);
    }


    function actionSelectall(int ...$result){
        return array_sum($result);
    }
}