<?PHP
/**
 * @brief 构造cache对象
 * @package              ganji.cache
 * @author               yangyu
 * @file                 $RCSfile: Curl.class.php,v $
 * @version              $Revision: 50890 $
 * @modifiedby           $Author: yangyu $
 * @lastmodified         $Date: 2011-03-11 17:29:21 +0800 (五, 2011-03-11) $
 * @copyright            Copyright (c) 2011, ganji.com
 */

class CacheUtil
{
    /** APC */
	const MODE_APC = 1;

	/** memcache */
	const MODE_MEMCACHE = 2;

    private static $_HANDLE_ARRAY   = array();

    private static function _getHandleKey($params) {
        ksort($params);
        return md5(implode('_' , $params));
    }

    /**
     * @brief 创建一个cache 对象
     *
     * @param $mode int cache的类型
     *
     * @see CacheBackingStore::MEMCACHE         memcache
     * @see CacheBackingStore::LOCAL_FILE       local_file
     * @see CacheMemcache
     * @see CacheFile
     *
     * @return  MemCacheAdapter|ApcCacheAdapter
     */
    public static function createCache($mode, $servers=array()) {

        $handle_key = self::_getHandleKey(array(
            'mode'      => $mode,
            'servers'   => serialize($servers),
        ));

        if (isset(self::$_HANDLE_ARRAY[$handle_key])) {
            return self::$_HANDLE_ARRAY[$handle_key];
        }

		switch($mode) {
			case self::MODE_MEMCACHE:
				require_once dirname(__FILE__) . '/adapter/MemCacheAdapter.class.php';
				$objCache = new MemCacheAdapter($servers);
				break;
			case self::MODE_APC:
			    require_once dirname(__FILE__) . '/adapter/ApcCacheAdapter.class.php';
				$objCache = new ApcCacheAdapter();
				break;
			default:
			    require_once dirname(__FILE__) . '/adapter/MemCacheAdapter.class.php';
				$objCache = new MemCacheAdapter($servers);
				break;
		}

		self::$_HANDLE_ARRAY[$handle_key]    = $objCache;

		return $objCache;
	}

    public static function encodeKey($key) {
        return urlencode($key);
    }
}

