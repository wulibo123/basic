<?php

/**
 * @brief  封装mssql
 * @author gaoshikao@qq.com
 */

class DBMssql {
    /**
     * 已打开的db handle
     * @var array
     */
    private static $_HANDLE_ARRAY   = array();

    private static $_LAST_SQL = '';

    private static function _getHandleKey($params) {
        ksort($params);
        return md5(implode('_' , $params));
    }

    /**
     * @brief 根据数据库表述的参数获取数据库操作句柄
     * @param[in] array $db_config_array, 是一个array类型的数据结构，必须有host, username, password 三个熟悉, port为可选属性， 缺省值分别为1433
     */
    public static function createDBHandle($db_config_array) {

        $handle_key = self::_getHandleKey($db_config_array);

        if (isset(self::$_HANDLE_ARRAY[$handle_key])) {
            return self::$_HANDLE_ARRAY[$handle_key];
        }

        if(!isset($db_config_array['host']) || empty($db_config_array['host'])){
            $db_config_array['host'] = 1433;
        }
        $handle = new PDO('dblib:host='.$db_config_array['host'] . ':' . $db_config_array['port'] .
            ';dbname='.$db_config_array['dbname'], $db_config_array['username'], $db_config_array['password']);
        if($handle){
            self::$_HANDLE_ARRAY[$handle_key]    = $handle;
            return $handle;
        }
        return false;
    }

    /**
     * @brief 执行sql语句， 该语句必须是insert, update, delete, create table, drop table等更新语句
     * @param[in] handle $handle, 操作数据库的句柄
     * @param[in] string $sql, 具体执行的sql语句
     * @return TRUE:表示成功， FALSE:表示失败
     */
    public static function execute($handle, $sql) {
        $stmt = $handle->prepare($sql);
        return $stmt->execute();
    }

    /**
     * @brief 执行insert sql语句，并获取执行成功后插入记录的id
     * @param[in] handle $handle, 操作数据库的句柄
     * @param[in] string $sql, 具体执行的sql语句
     * @return FALSE表示执行失败， 否则返回insert的ID
     */
    public static function insertAndGetID($handle, $sql) {
        $stmt = $handle->prepare($sql);
        $stmt->execute();

        return $handle->lastInsertId();
    }

    /**
     * @brief 将所有结果存入数组返回
     * @param[in] handle $handle, 操作数据库的句柄
     * @param[in] string $sql, 具体执行的sql语句
     */
    public static function queryAll($handle, $sql) {
        $stmt = $handle->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $res;
    }

    /**
     * @brief 将查询的第一条结果返回
     * @param[in] handle $handle, 操作数据库的句柄
     * @param[in] string $sql, 具体执行的sql语句
     */
    public static function queryRow($handle, $sql) {
        $stmt = $handle->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    /**
     * @brief 查询第一条结果的第一列
     * @param Mysqli $handle, 操作数据库的句柄
     * @param string $sql, 具体执行的sql语句
     */
    public static function queryOne($handle , $sql) {
        $row = self::queryRow($handle, $sql);
        if (is_array($row)) {
            return current($row);
        }
        return $row;
    }

}
