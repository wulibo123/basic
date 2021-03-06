<?php
/**
 * 数据库配置类
 */
class DBConfig {

    /**
     * 数据库名称
     */
    const DB_WEB            = '51tz';
    const DB_FORUM          = '51zx_forum';
    const DB_MARIO          = 'mogu_51zx';
    const DB_WECHAT         = 'www';
    const DB_CUSTOM         = '51zx_custom';
    const DB_MOGU_FORUM     = 'forum';
    const DB_MOGU_WP        = 'mogu_blog';

    /**
     * 主库
     */
    const COMMON_MASTER_HOST     = 'localhost';
    const COMMON_MASTER_USERNAME = 'miaowudz';
    const COMMON_MASTER_PASSWD   = 'TeST_miaowudz-Db-demoN';
    const COMMON_MASTER_PORT     = '3306';
    const COMMON_MASTER_SOCKET   = '';
    /**
     * 从库
     */
    const COMMON_SLAVE_HOST     = 'localhost';
    const COMMON_SLAVE_USERNAME = 'miaowudz';
    const COMMON_SLAVE_PASSWD   = 'TeST_miaowudz-Db-demoN';
    const COMMON_SLAVE_PORT     = '3306';
    const COMMON_SLAVE_SOCKET   = '';

    //主站主库
    public static $SERVER_MASTER = array(
        'host'      => self::COMMON_MASTER_HOST,
        'username'  => self::COMMON_MASTER_USERNAME,
        'password'  => self::COMMON_MASTER_PASSWD,
        'port'      => self::COMMON_MASTER_PORT,
        'socket'    => self::COMMON_MASTER_SOCKET
    );

    //主站副库
    public static $SERVER_SLAVE = array(
        'host'      => self::COMMON_SLAVE_HOST,
        'username'  => self::COMMON_SLAVE_USERNAME,
        'password'  => self::COMMON_SLAVE_PASSWD,
        'port'      => self::COMMON_SLAVE_PORT,
        'socket'    => self::COMMON_SLAVE_SOCKET
    );


    /**
     * 论坛数据库
     */
    const COMMON_FORUM_HOST     = 'localhost';
    const COMMON_FORUM_USERNAME = 'miaowudz';
    const COMMON_FORUM_PASSWD   = 'TeST_miaowudz-Db-demoN';
    const COMMON_FORUM_PORT     = '3306';
    const COMMON_FORUM_SOCKET   = '';

    //论坛数据库
    public static $SERVER_FORUM = array(
        'host'      => self::COMMON_FORUM_HOST,
        'username'  => self::COMMON_FORUM_USERNAME,
        'password'  => self::COMMON_FORUM_PASSWD,
        'port'      => self::COMMON_FORUM_PORT,
        'socket'    => self::COMMON_FORUM_SOCKET
    );

    /**
     * 蘑菇装修 后院
     */
    const COMMON_SLAVE_MARIO_WP_HOST     = 'localhost';
    const COMMON_SLAVE_MARIO_WP_USERNAME = 'miaowudz';
    const COMMON_SLAVE_MARIO_WP_PASSWD   = 'TeST_miaowudz-Db-demoN';
    const COMMON_SLAVE_MARIO_WP_PORT     = '3306';
    const COMMON_SLAVE_MARIO_WP_SOCKET   = '';

    //蘑菇装修 后院
    public static $SERVER_WP_MASTER_MARIO = array(
        'host'      => self::COMMON_SLAVE_MARIO_WP_HOST,
        'username'  => self::COMMON_SLAVE_MARIO_WP_USERNAME,
        'password'  => self::COMMON_SLAVE_MARIO_WP_PASSWD,
        'port'      => self::COMMON_SLAVE_MARIO_WP_PORT,
        'socket'    => self::COMMON_SLAVE_MARIO_WP_SOCKET
    );

    /**
     * 蘑菇装修 主库
     */
    const COMMON_MASTER_MARIO_HOST     = 'localhost';
    const COMMON_MASTER_MARIO_USERNAME = 'miaowudz';
    const COMMON_MASTER_MARIO_PASSWD   = 'TeST_miaowudz-Db-demoN';
    const COMMON_MASTER_MARIO_PORT     = '3306';
    const COMMON_MASTER_MARIO_SOCKET   = '';

    /**
     * 蘑菇装修 从裤
     */
    const COMMON_SLAVE_MARIO_HOST     = 'localhost';
    const COMMON_SLAVE_MARIO_USERNAME = 'miaowudz';
    const COMMON_SLAVE_MARIO_PASSWD   = 'TeST_miaowudz-Db-demoN';
    const COMMON_SLAVE_MARIO_PORT     = '3306';
    const COMMON_SLAVE_MARIO_SOCKET   = '';

    //蘑菇装修 主库
    public static $SERVER_MASTER_MARIO = array(
        'host'      => self::COMMON_MASTER_MARIO_HOST,
        'username'  => self::COMMON_MASTER_MARIO_USERNAME,
        'password'  => self::COMMON_MASTER_MARIO_PASSWD,
        'port'      => self::COMMON_MASTER_MARIO_PORT,
        'socket'    => self::COMMON_MASTER_MARIO_SOCKET
    );

    //蘑菇装修 从库
    public static $SERVER_SLAVE_MARIO = array(
        'host'      => self::COMMON_SLAVE_MARIO_HOST,
        'username'  => self::COMMON_SLAVE_MARIO_USERNAME,
        'password'  => self::COMMON_SLAVE_MARIO_PASSWD,
        'port'      => self::COMMON_SLAVE_MARIO_PORT,
        'socket'    => self::COMMON_SLAVE_MARIO_SOCKET
    );

    /**
     * 蘑菇装修 论坛
     */
    const COMMON_SLAVE_MARIO_FORUM_HOST     = 'localhost';
    const COMMON_SLAVE_MARIO_FORUM_USERNAME = 'miaowudz';
    const COMMON_SLAVE_MARIO_FORUM_PASSWD   = 'TeST_miaowudz-Db-demoN';
    const COMMON_SLAVE_MARIO_FORUM_PORT     = '3306';
    const COMMON_SLAVE_MARIO_FORUM_SOCKET   = '';

    //蘑菇装修 论坛
    public static $SERVER_BBS_MASTER_MARIO = array(
        'host'      => self::COMMON_SLAVE_MARIO_FORUM_HOST,
        'username'  => self::COMMON_SLAVE_MARIO_FORUM_USERNAME,
        'password'  => self::COMMON_SLAVE_MARIO_FORUM_PASSWD,
        'port'      => self::COMMON_SLAVE_MARIO_FORUM_PORT,
        'socket'    => self::COMMON_SLAVE_MARIO_FORUM_SOCKET
    );

    /**
     * 微信数据库
     */
    const COMMON_WECHAT_HOST     = 'localhost';
    const COMMON_WECHAT_USERNAME = 'miaowudz';
    const COMMON_WECHAT_PASSWD   = 'TeST_miaowudz-Db-demoN';
    const COMMON_WECHAT_PORT     = '3306';
    const COMMON_WECHAT_SOCKET   = '';

    //微信数据库
    public static $SERVER_WECHAT = array(
        'host'      => self::COMMON_WECHAT_HOST,
        'username'  => self::COMMON_WECHAT_USERNAME,
        'password'  => self::COMMON_WECHAT_PASSWD,
        'port'      => self::COMMON_WECHAT_PORT,
        'socket'    => self::COMMON_WECHAT_SOCKET
    );

    /**
     * 数据共享
     */
    const COMMON_CUSTOM_HOST     = 'localhost';
    const COMMON_CUSTOM_USERNAME = 'miaowudz';
    const COMMON_CUSTOM_PASSWD   = 'TeST_miaowudz-Db-demoN';
    const COMMON_CUSTOM_PORT     = '3306';
    const COMMON_CUSTOM_SOCKET   = '';

    //微信数据库
    public static $SERVER_CUSTOM = array(
        'host'      => self::COMMON_CUSTOM_HOST,
        'username'  => self::COMMON_CUSTOM_USERNAME,
        'password'  => self::COMMON_CUSTOM_PASSWD,
        'port'      => self::COMMON_CUSTOM_PORT,
        'socket'    => self::COMMON_CUSTOM_SOCKET
    );
}