<?php

class BaseImpl{
    //脚本进程内的cache
    private static $_CACHE_DATA = array();

    //读取缓存
    protected static function _loadCache($key) {
        // 若已取过此key，直接返回
        if (isset(self::$_CACHE_DATA[$key])) {
            return self::$_CACHE_DATA[$key];
        }

        // 文件缓存
        $data   = self::_getFileCache($key);

        // 数据找不到
        if (!$data) {
            return null;
        }

        // 存入内存缓存
        self::$_CACHE_DATA[$key]    = $data;
        return $data;
    }


    //通过文件获取缓存
    protected static function _getFileCache($key) {
        // 文件缓存
        $file   = self::_getCachePath($key);

        if (!file_exists($file)) {
            return null;
        }

        $string = @file_get_contents($file);
        if (strlen($string) == 0) {
            return null;
        }

        $content    = @unserialize($string);

        return $content;
    }

    //写入缓存
    protected static function _saveCache($key , $data) {
        // 文件缓存，创建目录
        $path       = self::_getCachePath($key);
        $dir_path   = dirname($path);
        if (!is_dir($dir_path)) {
            mkdir($dir_path , 0755, true);
        }

        return @file_put_contents($path , serialize($data));
    }

    //获取文件缓存路径
    protected static function _getCachePath($key) {
        return DATA_PATH . '/' . $key;
    }
}