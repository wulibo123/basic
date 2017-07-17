<?php
require_once FRAMEWORK_PATH . '/util/http/HttpRequest.class.php';
require_once CONF_PATH . '/sms/SmsConfig.class.php';

class SmsUtil{

    //短信营销通道
    public static function sendMessageDX($mobileArr, $content){
        if(!count($mobileArr) or empty($content)){
            return false;
        }
        $mobileList = implode(',', $mobileArr);
        $postParams = array(
            'pid' => SmsConfig::DX_PID,
            'account' => SmsConfig::DX_ACCOUNT,
            'password' => SmsConfig::DX_PASSWORD,
            'mobile' => $mobileList,
            'content' => $content
        );
        $ch = curl_init();
        $curlOpts = array(
            CURLOPT_CONNECTTIMEOUT    => 3,
            CURLOPT_TIMEOUT           => 5,
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_FOLLOWLOCATION    => false,
            CURLOPT_HTTPHEADER        => array('Host: 10658.cc'),
            CURLOPT_URL               => 'http://121.199.40.105/webservice/api?method=SendSms',
            CURLOPT_POSTFIELDS        => array(
                'pid' => SmsConfig::DX_PID,
                'account' => SmsConfig::DX_ACCOUNT,
                'password' => SmsConfig::DX_PASSWORD,
                'mobile' => $mobileList,
                'content' => $content
            )
        );

        curl_setopt_array($ch, $curlOpts);
        $result = curl_exec($ch);
        $result = self::xml_to_array($result);
        return $result['SendSmsResult']['code'] == 2;
    }

    //验证码营销通道
    public static function sendMessage($mobileArr, $content){
        if(!count($mobileArr) || empty($content)){
            return false;
        }
        $mobileList = implode(',', $mobileArr);
        $postParams = '&account=' . SmsConfig::ACCOUNT . '&' .
            'password=' . SmsConfig::PASSWORD . '&' .
            'mobile=' . $mobileList . '&' .
            'content=' . $content;

        $result = HttpRequest::get(SmsConfig::INTERFACE_URL . $postParams);
        file_put_contents(DATA_PATH.'/sms.log', $result, FILE_APPEND);
        $result = self::xml_to_array($result);

        return $result['SubmitResult']['code'] == 2;
    }

    //蘑菇装修预约通道
    public static function sendMessageMG($mobile, $content){
        if(empty($mobile) or empty($content)){
            return false;
        }
        $postParams = array(
            'account'  => SmsConfig::MG_ACCOUNT,
            'password' => SmsConfig::MG_PASSWORD,
            'mobile'   => $mobile,
            'content'  => $content
        );

        $result = HttpRequest::httpPostByCurl(SmsConfig::MG_INTERFACE_URL, $postParams);
        $result = self::xml_to_array($result);
        if(!DEBUG_STATUS) {
            $person = date('Y-m-d H:i:s').'-------mobile:'.$mobile.'------code:'.$result['SubmitResult']['code'].'------msg:'.$result['SubmitResult']['msg'].'-----消息ID:'.$result['SubmitResult']['smsid']."\r\n";
            error_log($person, 3, '/data/log/php/sms_log.txt');
        }
        return $result['SubmitResult']['code'] == 2;
    }

    private static function xml_to_array($xml){
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if(preg_match_all($reg, $xml, $matches)){
            $count = count($matches[0]);
            for($i = 0; $i < $count; $i++){
            $subxml= $matches[2][$i];
            $key = $matches[1][$i];
                if(preg_match( $reg, $subxml )){
                    $arr[$key] = self::xml_to_array( $subxml );
                }else{
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }

    //51装修预约通道
    public static function sendMessage51($mobile, $content){
        if(empty($mobile) or empty($content)){
            return false;
        }
        $postParams = array(
            'account'  => SmsConfig::ACCOUNT,
            'password' => SmsConfig::PASSWORD,
            'mobile'   => $mobile,
            'content'  => $content
        );

        $result = HttpRequest::httpPostByCurl(SmsConfig::INTERFACE_URL, $postParams);
        $result = self::xml_to_array($result);

        //require_once 'zxcom/zxcom.php';
        $log_res = \Zxcom\Sms\SmsSender::zxSmsLog(array('result' => $result['SubmitResult']  ,'mobile'=>$mobile , 'content' => $content ));
        //if(!$log_res)var_dump($log_res);

        if(!DEBUG_STATUS) {
            $person = date('Y-m-d H:i:s').'-------mobile:'.$mobile.'------code:'.$result['SubmitResult']['code'].'------msg:'.$result['SubmitResult']['msg'].'-----消息ID:'.$result['SubmitResult']['smsid']."\r\n";
            error_log($person, 3, '/data/log/php/sms_log.txt');
        }
        return $result['SubmitResult']['code'] == 2;
    }



    /**
     * ²úÉúËæ»úÂë
     * @param $numberic - Êý×Ö»¹ÊÇ×Ö·û´®
     * @return ·µ»Ø×Ö·û´®
    */
    public static function randomStr($length = 6, $numeric = 0) {
        if($numeric) {
            $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
            $max = strlen($chars) - 1;
            for($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }

    public static function microtimeFloat() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}
