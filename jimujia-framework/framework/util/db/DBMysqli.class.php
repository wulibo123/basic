<?php

/**
 * @brief  封装mysqli
 * @author longwg
 */

class DBMysqli {

    // 编码定义
    const ENCODING_GBK      = 0;
    const ENCODING_UTF8     = 1;
    const ENCODING_LATIN    = 2;

    // 数据库句柄需要ping
    const HANDLE_PING       = 100;

    const SLOW_QUERY_MIN = 50;
    const SLOW_QUERY_SAMPLE = 500;

    /**
     * @biref 数据库句柄是否需要ping
     * @var mix
     */
    private static $_HANDLE_PING = false;

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
     * @brief 设置 handle ping的属性
     * @param $value
     * @return unknown_type
     * @example
     *      如果是crontabe 建议在开始是增加
     *      DBMysql::setHandlePing(self::HANDLE_PING);
     *      如果关闭可以设置 false, 默认是不开启的
     *      DBMysql::setHandlePing();
     */
    public static function setHandlePing($value = false) {
        self::$_HANDLE_PING = $value;
    }

    /**
     * @brief 根据数据库表述的参数获取数据库操作句柄
     * @param[in] array $db_config_array, 是一个array类型的数据结构，必须有host, username, password 三个熟悉, port为可选属性， 缺省值分别为3306
     * @param[in] string $db_name, 数据库名称
     * @param[in] enum $encoding, 从数据库编码相关的常量定义获取, 有缺省值ENCODING_UTF8
     * @return 非FALSE表示成功获取hadnle， 否则返回FALSE
     */
    public static function createDBHandle($db_config_array, $db_name, $encoding = self::ENCODING_UTF8) {

        $db_config_array['db_name']     = $db_name;
        $db_config_array['encoding']    = $encoding;
        $handle_key = self::_getHandleKey($db_config_array);

        if (isset(self::$_HANDLE_ARRAY[$handle_key])) {
            return self::$_HANDLE_ARRAY[$handle_key];
        }

        $port = 3306;
        do {
            if (!is_array($db_config_array)) {
                break;
            }
            if (!is_string($db_name)) {
                break;
            }
            if (strlen($db_name) == 0) {
                break;
            }
            if (!array_key_exists('host', $db_config_array)) {
                break;
            }
            if (!array_key_exists('username', $db_config_array)) {
                break;
            }
            if (!array_key_exists('password', $db_config_array)) {
                break;
            }
            if (array_key_exists('port', $db_config_array)) {
                $port = (int)($db_config_array['port']);
                if (($port < 1024) || ($port > 65535)) {
                    break;
                }
            }
            $host = $db_config_array['host'];
            if (strlen($host) == 0) {
                break;
            }
            $username = $db_config_array['username'];
            if (strlen($username) == 0) {
                break;
            }
            $password = $db_config_array['password'];
            if (strlen($password) == 0) {
                break;
            }
            $socket = $db_config_array['socket'];

            $handle = @mysqli_connect($host, $username, $password, $db_name, $port, $socket);

            // 如果连接失败，再重试2次
            for ($i = 1; ($i < 3) && (false === $handle); $i++) {
                // 重试前需要sleep 50毫秒
                usleep(50000);
                $handle = @mysqli_connect($host, $username, $password, $db_name, $port, $socket);
            }
            if (false === $handle) {
                break;
            }

            $is_encoding_set_success = true;
            switch ($encoding) {
                case self::ENCODING_UTF8 :
                    $is_encoding_set_success = mysqli_set_charset($handle, "utf8");
                    break;
                case self::ENCODING_GBK :
                    $is_encoding_set_success = mysqli_set_charset($handle, "gbk");
                    break;
                default:
            }
            if (false === $is_encoding_set_success) {
                mysqli_close($handle);
                break;
            }
            self::$_HANDLE_ARRAY[$handle_key]    = $handle;
            return $handle;
        } while (false);

        $password_part = substr($password,0,5) . '...';
        $logArray = $db_config_array;
        $logArray['password'] = $password_part;
        self::logError( sprintf("Connect failed:db_config_array=%s", var_export($logArray, true)), 'mysqlns.connect');

        return false;
    }

    /**
     * @brief 释放通过getDBHandle或者getDBHandleByName 返回的句柄资源
     * @param[in] handle $handle, 你懂的
     * @return void
     */
    public static function releaseDBHandle($handle) {
        if (!self::_checkHandle($handle)) {
            return;
        }
        foreach (self::$_HANDLE_ARRAY as $handle_key => $handleObj) {
            if ($handleObj->thread_id == $handle->thread_id) {
                unset(self::$_HANDLE_ARRAY[$handle_key]);
            }
        }
        mysqli_close($handle);
    }

    /**
     * @brief 执行sql语句， 该语句必须是insert, update, delete, create table, drop table等更新语句
     * @param[in] handle $handle, 操作数据库的句柄
     * @param[in] string $sql, 具体执行的sql语句
     * @return TRUE:表示成功， FALSE:表示失败
     */
    public static function execute($handle, $sql) {
        //$sql = mysqli_real_escape_string($handle, $sql);
        if (!self::_checkHandle($handle)) {
            return false;
        }
        self::$_LAST_SQL = $sql;
        $tm = self::getMicrosecond();
        if (mysqli_query($handle, $sql)) {

            $tm_used = intval( self::getMicrosecond() - $tm);
            if( $tm_used > self::SLOW_QUERY_MIN && rand(0, self::SLOW_QUERY_SAMPLE) == 1) {
                 self::logWarn( "seconds=$tm_used, SQL=$sql", 'mysqlns.slow' );
            }

            return true;
        }
        self::logError( "SQL Error: $sql," . self::getLastError($handle), 'mysqlns.sql');

        return false;
    }

    /**
     * @brief 执行insert sql语句，并获取执行成功后插入记录的id
     * @param[in] handle $handle, 操作数据库的句柄
     * @param[in] string $sql, 具体执行的sql语句
     * @return FALSE表示执行失败， 否则返回insert的ID
     */
    public static function insertAndGetID($handle, $sql) {
        //$sql = mysqli_real_escape_string($handle, $sql);
        if (!self::_checkHandle($handle)) {
            return false;
        }
        self::$_LAST_SQL = $sql;
        do {
            if (false === mysqli_query($handle, $sql)) {
                break;
            }
            if ((false === $result = mysqli_query($handle, 'select LAST_INSERT_ID() AS LastID'))) {
                break;
            }
            $row = mysqli_fetch_assoc($result);
            $lastid = $row['LastID'];
            mysqli_free_result($result);
            return $lastid;
        } while (false);

        self::logError( "SQL Error: $sql," . self::getLastError($handle), 'mysqlns.sql');

        return false;
    }

    /**
     * @brief 将所有结果存入数组返回
     * @param[in] handle $handle, 操作数据库的句柄
     * @param[in] string $sql, 具体执行的sql语句
     * @return FALSE表示执行失败， 否则返回执行的结果, 结果格式为一个数组，数组中每个元素都是mysqli_fetch_assoc的一条结果
     */
    public static function queryAll($handle, $sql) {
        //echo $sql.'<hr>';
        //$sql = mysqli_real_escape_string($handle, $sql);
        if (!self::_checkHandle($handle)) {
            return false;
        }
        self::$_LAST_SQL = $sql;
        do {
            $tm = self::getMicrosecond();
            if ((false === $result = mysqli_query($handle, $sql))) {
                break;
            }
            $tm_used = intval(self::getMicrosecond() - $tm);

            if( $tm_used > self::SLOW_QUERY_MIN && rand(0, self::SLOW_QUERY_SAMPLE) == 1) {
                self::logWarn( "seconds=$tm_used, SQL=$sql", 'mysqlns.slow' );
            }

            $res = array();
            while($row = mysqli_fetch_assoc($result)) {
                //数据库统一以id作为主键自增字段，所以如果有id字段，则以此做为数组下标
                if(isset($row['id'])){
                    $res[$row['id']] = $row;
                }else{
                    $res[] = $row;
                }
            }
            mysqli_free_result($result);
            return $res;
        } while (false);

        self::logError( "SQL Error: $sql," . self::getLastError($handle), 'mysqlns.sql');

        return false;
    }

    /**
     * @brief 将查询的第一条结果返回
     * @param[in] handle $handle, 操作数据库的句柄
     * @param[in] string $sql, 具体执行的sql语句
     * @return FALSE表示执行失败， 否则返回执行的结果, 执行结果就是mysqli_fetch_assoc的结果
     */
    public static function queryRow($handle, $sql) {
        //echo $sql.'<hr>';
        //$sql = mysqli_real_escape_string($handle, $sql);
        if (!self::_checkHandle($handle)) {
            return false;
        }
        self::$_LAST_SQL = $sql;
        do {
            $tm = self::getMicrosecond();
            if ((false === $result = mysqli_query($handle, $sql))) {
                break;
            }
            $tm_used = intval( self::getMicrosecond() - $tm);
            if( $tm_used > self::SLOW_QUERY_MIN && rand(0, self::SLOW_QUERY_SAMPLE) == 1) {
                self::logWarn( "seconds=$tm_used, SQL=$sql", 'mysqlns.slow' );
            }

            $row = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
            return $row;
        } while (false);
        self::logError( "SQL Error: $sql," . self::getLastError($handle), 'mysqlns.sql');
        return false;
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

    /**
     * @brief 得到最近一次操作影响的行数
     * @param[in] handle $handle, 操作数据库的句柄
     * @return FALSE表示执行失败， 否则返回影响的行数
     */
    public static function lastAffected($handle) {
        if (!self::_checkHandle($handle)) {
            return false;
        }
        $affected_rows = mysqli_affected_rows($handle);
        if ($affected_rows < 0) {
            return false;
        }
        return $affected_rows;
    }

    /**
     * @brief 得到最近一次操作错误的信息
     * @param[in] handle $handle, 操作数据库的句柄
     * @return false表示执行失败， 否则返回 'errorno: errormessage'
     */
    public static function getLastError($handle) {
        if (!self::_checkHandle($handle)) {
            return false;
        }
        if(mysqli_errno($handle)) {
            return mysqli_errno($handle).': '.mysqli_error($handle);
        }
        return false;
    }

    /**
     * @brief 检查handle
     * @param[in] handle $handle, 操作数据库的句柄
     * @return boolean true|成功, false|失败
     */
    private static function _checkHandle($handle) {
        if (!is_object($handle)) {
            self::logError(sprintf("handle Error: handle='%s'",var_export($handle, true)), 'mysqlns.handle');
            return false;
        }

        // MSC-2077 命令行模式 或者 手工指定 handle_ping
        if ((PHP_SAPI === 'cli' || self::$_HANDLE_PING === self::HANDLE_PING)
            && method_exists($handle, 'ping')) {
            // 做3次ping
            $tryCount = 3;
            $pingRet = false;
            do {
                $pingRet = $handle->ping();
                if ($pingRet) {
                    break;
                }
                $tryCount --;
            } while ($tryCount > 0);
            if (!$pingRet) {
                self::logError(sprintf("handle_ping Error: handle='%s'",var_export($handle, true)), 'mysqlns.handle.ping');
                return false;
            }
        }
        return true;
    }

    /**
     * @brief 记录统一的警告日志
     * @param[in] string $message, 错误消息
     * @param[in] string $category, 错误的子类别
     */
    protected static function logError($message, $category) {
        file_put_contents(DATA_PATH . '/log/error/' . $category, $message . "\t" . date("Y-m-d H:i:s") . "\n", FILE_APPEND);
        //echo $category .': '.$message."\n";
        //if(class_exists('Logger')) {
        //    Logger::logError($message, $category);
        //}
    }

    /**
     * @brief 记录统一的警告日志
     * @param[in] string $message, 错误消息
     * @param[in] string $category, 错误的子类别
     */
    protected static function logWarn($message, $category) {
        file_put_contents(DATA_PATH . '/log/warn/' . $category, $message . "\t" . date("Y-m-d H:i:s") . "\n", FILE_APPEND);
        //if(class_exists('Logger')) {
        //    Logger::logWarn($message, $category);
        //}
    }

    protected static function getMicrosecond() {
        list($usec, $sec) = explode(" ", microtime());
        return $sec*1000000 + (int)($usec * 1000000);
    }

}
