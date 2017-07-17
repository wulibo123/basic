<?php
/**
* 	配置账号信息
*/
define('REALDIRNAME', realpath(dirname(__FILE__)));
define('WECHAT_SSLCERT_PATH', REALDIRNAME.'/cacert/apiclient_cert.pem');
define('WECHAT_SSLKEY_PATH', REALDIRNAME.'/cacert/apiclient_key.pem');

class WxPayConf_pub
{
	//基本信息设置
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	const APPID = 'wx16435aaadc6e892d';
	//受理商ID，身份标识
	const MCHID = '10021679';
	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	const KEY = 'a1b2c3d4e5f6g7h8i9abcdefghijklmn';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	const APPSECRET = '11ce04c84d044b5c2d9b4db19d9cda49';

	//证书路径,注意应该填写绝对路径
	const SSLCERT_PATH = WECHAT_SSLCERT_PATH;
	const SSLKEY_PATH = WECHAT_SSLKEY_PATH;

	//异步通知url设置
	const NOTIFY_URL = 'index.php?ctl=payment&act=notify&class_name=WechatQrcode';

	//curl超时设置
	const CURL_TIMEOUT = 30;
}