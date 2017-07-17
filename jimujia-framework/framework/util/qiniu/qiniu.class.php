<?php
require_once __DIR__ . '/autoload.php';

// 引入鉴权类
use Qiniu\Auth;

// 引入上传类
use Qiniu\Storage\UploadManager;


class qiniu
{

    // 需要填写你的 Access Key 和 Secret Key
    private static $accessKey = 'fvUXK7gYjzjUIQrzpy9F-5e6lQYcWxFhukJu_Zmc';
    private static $secretKey = 'jL7-VZdSei14eHQE4yo_ZMf-PkrSWO5_qskmj3ja';

    private $token;

    public function __construct($bucket)
    {
        // 构建鉴权对象
        $auth = new Auth(self::$accessKey, self::$secretKey);

        // 要上传的空间
        //$bucket = 'static-51zx-com';

        // 生成上传 Token
        $this->token = $auth->uploadToken($bucket);

    }


    public function upload($filePath){

        // 要上传文件的本地路径
        //$filePath = '/home/work/pdp/webroot/mario/wwwroot/static/images/404-bg.png';

        // 上传到七牛后保存的文件名
        $key = md5(rand(1,99999).time());

        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($this->token, $key, $filePath);
        //echo "\n====> putFile result: \n";
        if ($err !== null)
        {
            return array('error'=> $err);
        }

        else {
            return $ret;
        }

    }
}