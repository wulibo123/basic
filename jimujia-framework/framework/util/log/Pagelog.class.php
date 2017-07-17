<?php

/*
    全球 IPv4 地址归属地数据库(17MON.CN 版)
    高春辉(pAUL gAO) <gaochunhui@gmail.com>
    Build 20141009 版权所有 17MON.CN
    (C) 2006 - 2014 保留所有权利
    请注意及时更新 IP 数据库版本
    数据问题请加 QQ 群: 346280296
    Code for PHP 5.3+ only
*/

require_once API_PATH . '/model/PagelogModel.class.php';
require_once API_PATH . '/model/LogvisitModel.class.php';


class Pagelog
{
    private static $pagelogM     = NULL;







    private static function init()
    {
        self::$pagelogM = new PagelogModel();

        //检查访客
        if(!isset($_COOKIE['b_void']) || strlen($_COOKIE['b_void']) != 16){
            $b_void = substr(md5('mogu'.microtime().rand(0,9999999)),8,16);
            setcookie('b_void',$b_void, time() + 300*24*3600,'/', '.'.SystemConfig::DOMAIN_MOGU);
            $_SESSION['b_void'] = $b_void;
        }else{
            $_SESSION['b_void'] = $_COOKIE['b_void'];
        }



        //访问id

        if(!$_COOKIE['b_vid'] || !is_numeric($_COOKIE['b_vid'])){ //生成新的vid
            $lv = new LogvisitModel();
            $id = $lv->insert(array('visitor_id'=>$_SESSION['b_void']));
            setcookie('b_vid',$id, time() + 12*3600,'/', '.'.SystemConfig::DOMAIN_MOGU);
            $_SESSION['b_vid'] = $id;
        }else{
            $_SESSION['b_vid'] = $_COOKIE['b_vid'];
        }


        //页数
        if(isset($_SESSION['page_log_pool']['page_num']) ){
            $_COOKIE['b_page_num'] > $_SESSION['page_log_pool']['page_num'] && $_SESSION['page_log_pool']['page_num'] = $_COOKIE['b_page_num'];
            ++$_SESSION['page_log_pool']['page_num'];
        }elseif($_COOKIE['b_page_num']){
            $_SESSION['page_log_pool']['page_num'] = intval($_COOKIE['b_page_num']) + 1;
        }else{
            $_SESSION['page_log_pool']['page_num'] = 1;
        }
        setcookie('b_page_num', $_SESSION['page_log_pool']['page_num'] , time() + 12*3600,'/', '.'.SystemConfig::DOMAIN_MOGU);

    }


    public static function logStart(){
            //return;

        if(stristr($_SERVER['REQUEST_URI'] , 'favicon.ico') !== false)return;
        if(stristr($_SERVER['REQUEST_URI'] , 'pagelog') !== false)return;

        //self::init();
//echo '<pre>';
//var_dump($_SERVER);

        $data = array(

            'server_start_time' => intval($_SERVER['REQUEST_TIME_FLOAT'] * 1000 ),
            //'ip' =>  $_SERVER['REMOTE_ADDR'],
            //'browser' =>  self::getBrowser(),
            //'platform' =>  self::getPlatform(),
            'url' =>  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
            //'add_time' =>  time(),

        );




        //链接池
        $_SESSION['page_log_pool'] = $_SESSION['page_log_pool'] ?: array();
        $_SESSION['page_log_pool'][md5($data['url'])] = $data['server_start_time'];
        $_SESSION['page_log_refs'][md5($data['url'])] = $_SERVER['HTTP_REFERER'];

        //self::logEnd();

        //记录referer 和 渠道 用于给boss传数据
        if(!preg_match('/^http:\/\/[a-zA-Z0-9]*\.{0,1}'.SystemConfig::DOMAIN_MOGU.'/' ,$_SERVER['HTTP_REFERER']) ){

            //echo $_COOKIE['name'];

            setcookie('b_referer', urlencode($_SERVER['HTTP_REFERER']),  time() + 12*3600, '/', '.'.SystemConfig::DOMAIN_MOGU);
            setcookie('b_source', isset($_GET['utm_source'])?$_GET['utm_source']:'',  time() + 12*3600, '/', '.'.SystemConfig::DOMAIN_MOGU);
            setcookie('b_medium', isset($_GET['utm_medium'])?$_GET['utm_medium']:'',  time() + 12*3600, '/', '.'.SystemConfig::DOMAIN_MOGU);
            setcookie('b_term', isset($_GET['utm_term'])?$_GET['utm_term']:'',  time() + 12*3600, '/', '.'.SystemConfig::DOMAIN_MOGU);
            setcookie('b_content', isset($_GET['utm_content'])?$_GET['utm_content']:'',  time() + 12*3600, '/', '.'.SystemConfig::DOMAIN_MOGU);
            setcookie('b_campaign', isset($_GET['utm_campaign'])?$_GET['utm_campaign']:'',  time() + 12*3600, '/', '.'.SystemConfig::DOMAIN_MOGU);

        }


    }

    /**
     * 记录页面加载完成 相关信息
     *
     *
     */
    public static function logEnd($type = 1,$userdata = array()){


        $server_start_time = 0;

        switch($type ){

            //访问页面（pv）
            case 1:{

                $server_start_time =  $_SESSION['page_log_pool'][md5($_SERVER['HTTP_REFERER'])];
                if(!$server_start_time)return;

            }break;

            //报名
            case 2:{

                $server_start_time = $_SESSION['page_log_pool'][md5( 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] )];
                $data['phone'] =  $userdata['phone'];

            }break;
            //精选报名
            case 4:{

                $server_start_time = $_SESSION['page_log_pool'][md5( 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] )];
                $data['phone'] =  $userdata['phone'];

            }break;
            //二次采集
            case 3:{

                $server_start_time = $_SESSION['page_log_pool'][md5( 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] )];
                $data['phone'] =  $userdata['phone'];

            }break;

            default: return;
        }
        self::init();


        $data['load_time'] =  intval($_SERVER['REQUEST_TIME_FLOAT'] * 1000 ) - $server_start_time;
        $data['visitor_id'] =  $_SESSION['b_void'];
        $data['visit_id'] =  $_SESSION['b_vid'];
        $data['ip'] =  $_SERVER['REMOTE_ADDR'];
        $data['browser'] =  self::getBrowser();
        $data['platform'] =  self::getPlatform();
        $data['add_time'] =  time();
        $data['type'] =  $type;
        $data['site'] =  (stristr($_SERVER['HTTP_REFERER'] , 'http://m.') || stristr($_SERVER['HTTP_REFERER'] , '.m.') || stristr($_SERVER['HTTP_REFERER'] , 'http://mpmogu.') ) ? 3 : 2 ;;
        $data['page_num'] =  $_SESSION['page_log_pool']['page_num'];
        $data['ref'] =  $data['page_num']==1 ? $_SESSION['page_log_refs'][md5($_SERVER['HTTP_REFERER'])] :'';
        $data['url'] =  $_SERVER['HTTP_REFERER'];
        $data['page'] =  self::formatUrl($_SERVER['HTTP_REFERER']);
        $data['domain'] =  $_SESSION['temp_domain']?:'xa';
        $data['keyword'] =  '';
        $data['utm_source'] =  $_COOKIE['b_source'];
        $data['utm_medium'] =  $_COOKIE['b_medium'];
        $data['utm_term'] =  $_COOKIE['b_term'];
        $data['utm_content'] =  $_COOKIE['b_content'];
        $data['utm_campaign'] =  $_COOKIE['b_campaign'];

        foreach($data as $k => $v){
            if(!$v) unset($data[$k]);
        }
        $re = self::$pagelogM->insert($data);

        unset( $_SESSION['page_log_pool'][md5($_SERVER['HTTP_REFERER'])]);
        unset( $_SESSION['page_log_refs'][md5($_SERVER['HTTP_REFERER'])]);

    }


    private static function getBrowser(){
        $agent=$_SERVER["HTTP_USER_AGENT"];
        if(strpos($agent,'MSIE')!==false || strpos($agent,'rv:11.0')) //ie11判断
            return "ie";
        else if(strpos($agent,'Firefox')!==false)
            return "firefox";
        else if(strpos($agent,'Chrome')!==false)
            return "chrome";
        else if(strpos($agent,'Opera')!==false)
            return 'opera';
        else if((strpos($agent,'Chrome')==false)&&strpos($agent,'Safari')!==false)
            return 'safari';
        else
            return 'unknown';
    }

    private static function getPlatform(){
        $agent=$_SERVER["HTTP_USER_AGENT"];

        if(stristr($_SERVER['HTTP_USER_AGENT'],'Android')) {
            return 'Android';
        }elseif(stristr($_SERVER['HTTP_USER_AGENT'],'iPhone')){
            return 'ios';
        }elseif(stristr($_SERVER['HTTP_USER_AGENT'],'Windows Phone')){
            return 'Windows Phone';
        }elseif (stristr($agent ,'win') && stristr($agent ,'nt 5.1')) {
            return "Windows XP";
        }
        elseif (stristr($agent ,'win') && stristr($agent ,'nt 6.0')) {
            return "Windows Vista";
        }
        elseif (stristr($agent ,'win') && stristr($agent ,'nt 6.1')) {
            return "Windows 7";
        }
        elseif (stristr($agent ,'win') && stristr($agent ,'32')) {
            return "Windows 32";
        }
        elseif (stristr($agent ,'win') && stristr($agent ,'nt')) {
            return "Windows NT";
        }elseif (stristr($agent ,'Mac OS')) {
            return "Mac OS";
        }
        elseif (stristr($agent ,'linux')) {
            return "Linux";
        }
        elseif (stristr($agent ,'unix')) {
            return "Unix";
        }
        else
            return 'unknown';
    }


    private static function formatUrl($url){
        $url = str_replace('http://','',$url);
        $cut_url = strstr($url,'?',true) ?: $url;	//？之前的部分
        $cut_url = strstr($cut_url , '/' ) ?: $cut_url;	// 第一个/之后的部分包括/

        if(substr($cut_url ,-1) == '/')
            $cut_url = substr($cut_url ,0,-1 );

        $cut_url == '/index.php' ? '': $cut_url;

        return $cut_url == '' ? '/': $cut_url;
    }



    private static function getlog($id){

        $result = file_get_contents('http://mgoas.moguzx.com/index.php?m=home&c=ttt&a=todata&id='.$id);
       // $result = file_get_contents('http://www.mgoas.com/index.php?m=home&c=ttt&a=todata&id='.$id);

        $result = json_decode($result , true);
if(!$result)die('lll');

        self::$pagelogM = new PagelogModel();
$sql = "INSERT INTO mg_log_page (id,visit_id,visitor_id , site,add_time,`domain`,spend_time,browser,platform,utm_source,utm_medium,utm_term,utm_content,utm_campaign,url,page) VALUES ";
        foreach($result as $v){
            $sql .= "('".implode("','",$v)."'),";
        }
        echo substr($sql,0, strlen($sql)-1);
        $re = self::$pagelogM->execute( str_replace('\\','',substr($sql ,0, strlen($sql)-1) ));
        var_dump($re);

        if($re)
        echo '<script>window.location.href="/default/pagelog?id='.$v['id'].'";</script>';

    }

    private static function getlogc($id){

        $result = file_get_contents('http://mgoas.moguzx.com/index.php?m=home&c=ttt&a=todatac&id='.$id);
        //$result = file_get_contents('http://www.mgoas.com/index.php?m=home&c=ttt&a=todatac&id='.$id);

        $result = json_decode($result , true);
        if(!$result)die('lll');

        self::$pagelogM = new PagelogModel();
        $sql = "INSERT INTO mg_log_page (visit_id,visitor_id , site,`type`,add_time,`domain`,phone,utm_source,utm_medium,utm_term,utm_content,utm_campaign,url,page) VALUES ";
        foreach($result as $v){
            $sql .= "('".implode("','",$v)."'),";
        }
        $sql = str_replace('\\','',substr($sql ,0, strlen($sql)-1) );
        $re = self::$pagelogM->execute( $sql);
        var_dump($re);

        echo $sql;

    }



}

?>