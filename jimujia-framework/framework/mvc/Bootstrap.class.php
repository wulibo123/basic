<?PHP

require_once dirname(__FILE__) . '/Dispatch.class.php';
require_once dirname(__FILE__) . '/BaseView.class.php';
require_once dirname(__FILE__) . '/../util/common/Helper.class.php';
require_once dirname(__FILE__) . '/../util/http/RequestUtil.class.php';
require_once dirname(__FILE__) . '/../util/http/ResponseUtil.class.php';
require_once dirname(__FILE__) . '/../vendor/autoload.php';

class Bootstrap {
    public static $CUSTOM_VARS = array();

    // 指定页面属性的querystring参数下标，只能字母数字
    public static $ROUTE_NAMES = array(
        'jsonp'      => '_jsonp',  // 用来指定jsonp的回调函数
        'dir'        => '_dir',    // 用来指定模块目录
        'module'     => '_mod',    // 用来指定模块名
        'action'     => '_act',    // 用来指定事件名
        'ajax'       => '_ajax',   // 用来指定是否为ajax请求，值为1或0
        'iframe'     => '_iframe', // 用来指定是否为iframe请求，值为1或0
    );

    private static $_routeParams = array();

    public static function setRouteParams($params = array()) {
        static $done = false;
        if (!$done) {
            $done = true;
            $routeNames = self::$ROUTE_NAMES;
            $ajax = (int) self::getValue($routeNames['ajax'], 0, true);

            /****
             * 修改蘑菇移动和pc路由 当三层路由时且为专题页配置页面（amlp，alp）时 将第三层（action）作为参数 即：
             * dir->module;
             * module->action;
             * action->参数;
             *
             * dubox  2016.12.06
             */

            if((defined('MOGU_MOBILE_V1') && self::getValue($routeNames['dir'], '', true) && self::getValue($routeNames['module'], 'default', true) == 'amlp')
                ||
                (defined('MOGU_V1') && self::getValue($routeNames['dir'], '', true) && self::getValue($routeNames['module'], 'default', true) == 'alp')
            ){

                $routeNames['args'] = $routeNames['action'];
                $routeNames['action'] = $routeNames['module'];
                $routeNames['module'] = $routeNames['dir'];
                $routeNames['dir'] = '';

            }


            self::$_routeParams = array(
                'dir'           => self::getValue($routeNames['dir'],    '', true),// 模块目录
                'module'        => self::getValue($routeNames['module'], 'default', true),// 模块名
                'action'        => self::getValue($routeNames['action'], 'default', true),// 事件名
                'ajax'          => $ajax,                                              // 是否为ajax请求
                'iframe'        => (int) self::getValue($routeNames['iframe'], 0, true),  // 是否为iframe请求
                'jsonp'         => self::getValue($routeNames['jsonp'],  '', true),       // jsonp请求的回调函数名
                'content_type'  => $ajax ? ResponseUtil::CONTENT_TYPE_JSONP            // contentType
                                         : ResponseUtil::CONTENT_TYPE_HTML,
                'args'          => array('arg1' => isset($routeNames['args'])?self::getValue($routeNames['args'], false, true):false),
            );

        }

        if (!empty($params)) {
            foreach ($params as $key => $attr) {
                if ($key != 'content_type') {
                    $attr = self::getValue($attr);
                    if ($key == 'ajax' || $key == 'iframe') {
                        $attr = (int) $attr;
                    }
                    self::$_routeParams[$key] = $attr;
                }
            }
            if (array_key_exists('ajax', $params)) {
                self::$_routeParams['content_type'] = self::$_routeParams['ajax']
                                                    ? ResponseUtil::CONTENT_TYPE_JSONP
                                                    : ResponseUtil::CONTENT_TYPE_HTML;
            }
        }
    }

    public static function getRouteParams(){
        return self::$_routeParams;
    }

    public static function getRouteValue($key){
        if (array_key_exists($key, self::$_routeParams)) {
            return self::$_routeParams[$key];
        }
        return false;
    }

    public static function setAppDir($path) {
        Dispatch::$APP_PATH = $path;
    }

    public static function addTemplateDir($path) {
        BaseView::addDir($path);
    }

    public static function addHelperDir($path) {
        Helper::addDir($path);
    }

    public static function run($routeParams = array()) {
        self::setRouteParams($routeParams);

        $attrs = self::getRouteParams();

        Dispatch::run(
            $attrs['module'],
            $attrs['action'],
            $attrs['dir'],
            $attrs['content_type'],
            $attrs['jsonp'],
            $attrs['args']
        );
    }

    private static function getValue($value, $default = '', $fromRequest = false) {
        if ($fromRequest) {
            $value = RequestUtil::getPOST($value, RequestUtil::getGET($value, $default));
        }
        return preg_replace("/^[^\w\d]+$/", "", $value);
    }
}
