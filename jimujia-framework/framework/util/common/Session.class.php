<?php
/**
 * @Copyright (c) 2014 51zx Inc
 * @file          SessionUtil.class.php
 * @author       gaoshikao@qq.com
 * @date          2014-09-28
 *
 * session操作的封装，所有使用session的文件，必须require_one本文件
 */
require_once CONF_PATH . '/server/SessionConfig.class.php';
require_once CONF_PATH . '/server/SystemConfig.class.php';
require_once FRAMEWORK_PATH . '/util/db/DBMysqli.class.php';

/**
 * @class: Session
 * @PURPOSE: Session是一个静态类，对session进行统计管理
 */
class Session {

    //db handle
    private static $_DB_HANDLE = null;

    //session life
    private static $_LIFETIME = 1440;

    //time now
    private static $_TIMESTAMP = 0;

    //session domain
    private static $_DOMAIN = '';


    public static function init() {
        //是否初始化过
        static $initFinish = FALSE;

        if ($initFinish) {
            return true;
        }

        self::$_LIFETIME = ini_get('session.gc_maxlifetime');
        self::$_TIMESTAMP = time();
        self::$_DOMAIN = SessionConfig::SESSION_DOMAIN_MAIN;

        // 设置session为自定义处理
        ini_set('session.save_handler', 'user');

        // 设置session handler
        session_set_save_handler(
            array('Session', 'open'),
            array('Session', 'close'),
            array('Session', 'read'),
            array('Session', 'write'),
            array('Session', 'destroy'),
            array('Session', 'gc')
        );

        // 开启session
        ini_set('session.cookie_domain', SystemConfig::DOMAIN_MAIN);
        ini_set('session.cookie_path', '/');
        ini_set('session.name', 'zxsid');
        session_start();

        // PHP程序执行完成后执行的函数
        register_shutdown_function('session_write_close');

        $initFinish = TRUE;
    }

    //打开session
    public static function open(){
        // 创建myql句柄
        self::$_DB_HANDLE = DBMysqli::createDBHandle(array(
            'host' => SessionConfig::SESSION_MYSQL_HOST,
            'username' => SessionConfig::SESSION_MYSQL_USERNAME,
            'password' => SessionConfig::SESSION_MYSQL_PASSWORD,
            'port' => SessionConfig::SESSION_MYSQL_PORT
        ), SessionConfig::SESSION_MYSQL_DBNAME);

        return true;
    }

    //关闭session
    public static function close(){
        self::gc(self::$_LIFETIME);
        DBMysqli::releaseDBHandle(self::$_DB_HANDLE);
        return true;
    }

    /**
     * 读取Session
     * @param string $sid
     */
    public static function read($sid) {
        $sql = "select content from session where sid = '".$sid."' and expire_time >= '".self::$_TIMESTAMP."' ".
            "and domain = '".self::$_DOMAIN."'";
        return DBMysqli::queryOne(self::$_DB_HANDLE, $sql);
    }

    /**
     * 写入Session
     * @access public
     * @param string $sid
     * @param String $data
     */
    public static function write($sid, $data) {
        $expireTime = self::$_TIMESTAMP + self::$_LIFETIME;
        $sql = "insert into session(sid, create_time, expire_time, content, domain) " .
               "values('".$sid."', '".self::$_TIMESTAMP."', '".$expireTime."', '".$data."', '".self::$_DOMAIN."')";
        $insertResult = DBMysqli::execute(self::$_DB_HANDLE, $sql);
        if(!$insertResult){
            $sql = "update session set expire_time = '".$expireTime."',content = '".$data."'" .
                "where sid = '".$sid."' and expire_time >= '".self::$_TIMESTAMP."' and domain = '".self::$_DOMAIN."'";
            DBMysqli::execute(self::$_DB_HANDLE, $sql);
        }
    }

    /**
     * 删除Session
     * @access public
     * @param string $sid
     */
    public static function destroy($sid) {
        $sql = "delete from session where sid = '".$sid."' and domain = '".self::$_DOMAIN."'";
        return DBMysqli::execute(self::$_DB_HANDLE, $sql);
    }


    /**
     * Session 垃圾回收
     * @access public
     * @param string $sessMaxLifeTime
     */
    public static function gc($sessMaxLifeTime) {
        $sql = "delete from session where expire_time < '".self::$_TIMESTAMP."' and domain = '".self::$_DOMAIN."'";
        return DBMysqli::execute(self::$_DB_HANDLE, $sql);
    }

    //闪存
    public static function flashData($key, $value=NULL) {
        self::init();
        if($value===NULL) {
            if (isset($_SESSION[$key])) {
                $value = $_SESSION[$key];
                unset($_SESSION[$key]);
            }
        } else {
            $_SESSION[$key] = $value;
        }
        return $value;
    }

    /// @brief 向session中存入某个值
    /// @param $key string SESSION中的key
    /// @param $value unknown_type 要存入SESSION的值
    /// @return unknown_type 返回当前key对应的旧值，如果原来key不存在，则返回NULL
    public static function setValue($key, $value) {
        self::init();
        $ret = NULL;
        if (isset($_SESSION[$key])) {
            $ret = $_SESSION[$key];
        }
        $_SESSION[$key] = $value;
        return $ret;
    }

    /// @brief 从session中获取某个值
    /// @param $key string SESSION中的key
    /// @param $default 设置未找到SESSION的返回值，默认是NULL
    /// @return SESSION的值，未找到默认返回NULL

    public static function getValue($key, $default=NULL) {
        self::init();
        if (isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        return $default;
    }

    /// @brief 判断SESSION是否存在指定key
    /// @param $key string SESSION中的key
    /// @return bool 返回真或者假

    public static function isExists($key) {
        self::init();
        return isset($_SESSION[$key]);
    }

    /// @brief 从session中删除某个值
    /// @param $key string SESSION中的key

    public static function delete($key) {
        self::init();
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /// @brief 清空Session

    public static function clear() {
        self::init();
        session_unset();
        session_destroy();
    }

    public static function getSessionId() {
        self::init();
        return session_id();
    }

}