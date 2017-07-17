<?php
/**
 * mssql数据库配置类
 */
class MssqlConfig {
    //主站数据库
    const DB_WWW        = 'oldman';
    const BD_WWW_HOST   = 'rdsmv7vjyze3izy.sqlserver.rds.aliyuncs.com';
    const BD_WWW_USER   = 'oldman';
    const BD_WWW_PASS   = 'jiJ7aun4Im1Em2cE';
    const BD_WWW_PORT   = '3433';

    //装修事业部的数据库
    const DB_DECORATE        = 'oldwoman';
    const BD_DECORATE_HOST   = 'rdsmv7vjyze3izy.sqlserver.rds.aliyuncs.com';
    const BD_DECORATE_USER   = 'oldwoman';
    const BD_DECORATE_PASS   = 'euB4coth3ciDd9en';
    const BD_DECORATE_PORT   = '3433';

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
