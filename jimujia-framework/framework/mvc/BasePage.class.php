<?php

require_once dirname(__FILE__) . '/PageVars.class.php';
require_once dirname(__FILE__) . '/BaseView.class.php';


class BasePage {

    // 当前页面类型，参考PageVars::PAGE_*，在子类指定
    protected $pageType;

    // 访问类型，参考PageVars::ACCESS_*，在子类指定
    protected $accessType;

    // 前端变量
    protected $staticVars = array();

    // 模板引擎
    protected $view;

    // 运行时间记录
    private static $TIME = null;
    private static $TIME_ARRAY = array();
    private static $TIME_SPENT = array();

    // 构造函数
    public function __construct() {
        $this->view = new BaseView();
    }

    public function init() {}

    protected static function _time($name = '', $timeKey = null) {
        if (self::$TIME === false) {
            return;
        }
        if (self::$TIME === null) {
            $debug = RequestUtil::getGET('__debug');
            if ($debug === 'timespent') {
                self::$TIME = true;
            } else {
                self::$TIME = false;
                return;
            }
        }

        list($usec, $sec) = explode(" ", microtime());
        $time = ((float)$usec + (float)$sec);
        if (self::$TIME === true && empty(self::$TIME_ARRAY)) {
            self::$TIME_ARRAY['total'] = $time;
        } else {
        }
        $spentTime = false;

        if ($timeKey === null) {
            if (is_numeric(self::$TIME)) {
                $spentTime = round((($time - self::$TIME)*1000), 1);
            }
            self::$TIME = $time;
        } else {
            if (isset(self::$TIME_ARRAY[$timeKey]) && is_numeric(self::$TIME_ARRAY[$timeKey])) {
                $spentTime = round((($time - self::$TIME_ARRAY[$timeKey])*1000), 1);
                self::$TIME_SPENT[$timeKey] = $spentTime;
            }
            self::$TIME_ARRAY[$timeKey] = $time;
        }

        if ($spentTime !== false) {
            if ($name !== '') {
                $name = $name.': ';
            }
            if ($timeKey !== null) {
                echo "<strong>{$name} {$spentTime}ms</strong><br />";
                if ($timeKey == 'total') {
                    echo "<br /><strong>总花费时间占比:</strong><br />";
                    foreach (self::$TIME_SPENT as $key => $val) {
                        if ($key != 'total') {
                            $percent = round($val/$spentTime, 4) * 100;
                            echo "<strong>{$key} —— {$percent}%</strong><br />";
                        }
                    }
                }
            } else {
                echo "{$name} {$spentTime}ms<br />";
            }
        }

    }

    protected function assign($key, $val='') {
        $this->view->assign($key, $val);
    }


    //函数名: compress_html
    //参数: $string
    //返回值: 压缩后的$string
    protected function compressHtml($string) {
        $string = str_replace("\r\n", '', $string); //清除换行符
        $string = str_replace("\n", '', $string); //清除换行符
        $string = str_replace("\t", '', $string); //清除制表符
        $pattern = array (
                        "/> *([^ ]*) *</", //去掉注释标记
                        "/[\s]+/",
                        "/<!--[\\w\\W\r\\n]*?-->/",
                        "/\" /",
                        "/ \"/",
                        "'/\*[^*]*\*/'"
                        );
        $replace = array (
                        ">\\1<",
                        " ",
                        "",
                        "\"",
                        "\"",
                        ""
                        );
        return preg_replace($pattern, $replace, $string);
    }

    protected function render($data, $tpl = '', $output = 1) {
        $attrs = Bootstrap::getRouteParams();
        if ($attrs['ajax']) {
            if (!empty($tpl)) {
                $data['data'] = $this->view->fetch($tpl, $data);
                if (isset($data['errorCode']) && $data['errorCode'] > 0) {
                    $data['errorMessage'] = $data['data'];
                }
            }
            $content = $data;
        } else {
            $content = $this->view->fetch($tpl, $data);
            //$content = $this->compressHtml($content);
        }
        if (!$output) {
            return $content;
        }
        $this->view->output($content, $attrs['content_type'], $attrs['jsonp']);
        exit;
    }

    protected function renderError($msg='操作失败，请重试！ ', $code=1) {
        $attrs = Bootstrap::getRouteParams();
        $url = '';
        if ($attrs['ajax']) {
            $url .= PageVars::URL_404_AJAX;
        } else if ($attrs['iframe']) {
            $url .= PageVars::URL_404_IFRAME;
        } else {
            $url .= PageVars::URL_404;
        }
        $url .= '?errorMessage=' . rawurlencode($msg) . '&errorCode=' . rawurlencode($code);

        $this->redirect($url);
    }

    protected function redirect($url) {
        $attrs = Bootstrap::getRouteParams();
        if (!empty($attrs['jsonp'])) {
            $url .= (strpos($url, '?') === false) ? '?' : '&';
            $url .= Bootstrap::$ROUTE_NAMES['jsonp'] . '=' . rawurlencode($attrs['jsonp']);
        }

        ResponseUtil::redirect($url, $attrs['iframe']);
    }
}
