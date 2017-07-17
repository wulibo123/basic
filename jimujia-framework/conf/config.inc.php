<?php
/**
 * 基础配置文件
 *
 * @author    gaosk <gaoshikao@qq.com>
 * @since     2013-2-28
 * @desc       基础配置文件
 */

define('DEBUG_STATUS', true);

if (DEBUG_STATUS) {
    define('CONF_PATH' , dirname(__FILE__) . '/debug');
    define('DISPLAY_ERROR_MOBILE_V1', true);
    define('DISPLAY_ERROR_MOGU_V1', true);
    define('DISPLAY_ERROR_MOGU_MOBILE_V1', true);
    define('DISPLAY_ERROR_WEB_V1', true);
    define('DISPLAY_ERROR_NEWS_V1', true);
} else {
    define('CONF_PATH' , dirname(__FILE__) . '/runtime');
    define('DISPLAY_ERROR_MOBILE_V1', false);
    define('DISPLAY_ERROR_MOGU_V1', false);
    define('DISPLAY_ERROR_MOGU_MOBILE_V1', true);
    define('DISPLAY_ERROR_WEB_V1', false);
    define('DISPLAY_ERROR_NEWS_V1', false);
}
///配置文件路径

define('FRAMEWORK_PATH' , CONF_PATH . '/../../framework');
///基础类库路径

define('API_PATH', CONF_PATH . '/../../api');
///api类库路径

define('DATA_PATH', CONF_PATH . '/../../../php-data');
///数据缓存路径

define('STATIC_PATH', CONF_PATH . '/../../static');
///静态文件(image,css,js)路径
