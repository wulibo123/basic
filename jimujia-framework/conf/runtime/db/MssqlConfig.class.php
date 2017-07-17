<?php
/**
 * mssql数据库配置类
 */
class MssqlConfig {

    //主站数据库
    const DB_WWW        = '51tzwww';
    const BD_WWW_HOST   = '192.168.199.182';
    const BD_WWW_USER   = 'sa';
    const BD_WWW_PASS   = 'a123456';
    const BD_WWW_PORT   = '1433';

    //装修事业部的数据库
    const DB_DECORATE        = 'decorate';
    const BD_DECORATE_HOST   = '192.168.199.182';
    const BD_DECORATE_USER   = 'sa';
    const BD_DECORATE_PASS   = 'a123456';
    const BD_DECORATE_PORT   = '1433';

    /**
     * 获取主站配置数组
     */
    public static function getWwwConfig(){
        return array(
            'host' => self::BD_WWW_HOST,
            'dbname' => self::DB_WWW,
            'username' => self::BD_WWW_USER,
            'password' => self::BD_WWW_PASS,
            'port' => self::BD_WWW_PORT
        );
    }

    /**
     * 获取装修事业部配置数组
     */
    public static function getDecorateConfig(){
        return array(
            'host' => self::BD_DECORATE_HOST,
            'dbname' => self::DB_DECORATE,
            'username' => self::BD_DECORATE_USER,
            'password' => self::BD_DECORATE_PASS,
            'port' => self::BD_DECORATE_PORT
        );
    }
}
