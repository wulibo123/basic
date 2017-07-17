<?php
/**
 * 搜索引擎抓取关键词
 * 用法：RefererKeyword::getKeyword('http://www.baidu.com/s?ie=utf-8&wd=%E7%A1%85%E8%97%BB%E6%B3%A5%E4%BB%B7%E6%A0%BC&tn=yesky2007_yesky_cpr&rsv_lu=14_pa&fenlei=mv6qUZNxTZn0IZRqIHcsn161PWm0T1YzmHm4rjN-n1cLn1fknHnY0AGo5yRvm1K9mHb4mWRYnvN-PAR0IAYqnH03nHbvrfKWuWYkP0KzmWYs0Akdpvbqn6KWUMw85g--TvV4nW0sPdq4ugPoXNqWTZc0TLPs5HD0TLPsnWYk0ZNzUjdCIZwsFHPKFHFAFHFATA-WFHF7XyN1pLb-nbNWUvY-nbmzPWT-nbmYPjc3rHcvPzRdwWD4FHF7Tv9YUys0');
 **/

class RefererKeyword{

    //搜索引擎
    private static $_SEARCH_FROM = array(
        'www.baidu.com' => ['baidu', '百度网页',['wd','word']],
        'www1.baidu.com' => ['baidu', '百度网页', ['wd']],
        'image.baidu.com' => ['baidu', '百度图片', ['word']],
        'tupian.baidu.com' => ['baidu', '百度图片', ['word']],
        'zhidao.baidu.com' => ['baidu', '百度知道', ['word']],
        'm.baidu.com' => ['baidu', '百度手机网页', ['word']],
        'tieba.baidu.com' => ['baidu', '百度贴吧', []],
        'wenku.baidu.com' => ['baidu', '百度文库', ['word']],
        'jingyan.baidu.com' => ['baidu', '百度经验', []],
        'baike.baidu.com' => ['baidu', '百度百科', []],
        'shangjia.baidu.com' => ['baidu', '百度商家', ['wd']],
        'cang.baidu.com' => ['baidu', '百度搜藏', []],
        //'www.haosou.com' => ['haosou', '好搜网页', ['q']],
        //'image.haosou.com' => ['haosou', '好搜图片', ['q']],
    	'www.so.com' => ['haosou', '好搜网页', ['q']],
    	'image.so.com' => ['haosou', '好搜图片', ['q']],
        'www.sogou.com' => ['sougou', '搜狗网页', ['query']],
        'zhishi.sogou.com' => ['sogou', '搜狗知识', ['query']],
        'pic.sogou.com' => ['sogou', '搜狗图片', ['query']],
        'wap.sogou.com' => ['sogou', '搜狗手机网页', ['keyword']],
        '123.sogou.com' => ['sogou', '搜狗网址导航', []],
        'm.sogou.com' => ['sogou', '搜狗手机网页', ['keyword']],
        'baike.sogou.com' => ['sogou', '搜狗百科', []],
        'cn.bing.com' => ['bing', '必应网页', ['q']],
        'www.google.com' => ['google', '谷歌网页', []],
        'www.google.com.hk' => ['google', '谷歌网页', []]
    );

    public static function getKeyword($referer = ''){
        if(empty($referer)){
            $referer = $_SERVER['HTTP_REFERER'];
        }
        $referer = self::_filter($referer);
        if(!$referer){
            return '';
        }

        $keyword = self::_searchEngine($referer);
        if($keyword){
            $_SESSION['se_key'] = $keyword;
        }
    }

    //过滤掉不统计的站
    private static function _filter($referer){
        //直接打开
        if(empty($referer) or $referer == '-'){
            return false;
        }

        //来自本站
        if(preg_match('/(51zx\.com|51tz\.com|51tuanzhuang\.com)/i', $referer)){
            return false;
        }

        return $referer;
    }

    //搜索应情监测
    private static function _searchEngine($referer){
        $urlInfo = parse_url($referer);

        //过滤空query查询
        if(!array_key_exists('query', $urlInfo) or !array_key_exists('host', $urlInfo)){
            return false;
        }

        if(!array_key_exists($urlInfo['host'], self::$_SEARCH_FROM)){
            return false;
        }

        //解析关键字
        parse_str(urldecode($urlInfo['query']), $paramArr);
        $engine = self::$_SEARCH_FROM[$urlInfo['host']];

        $keyword = '';
        $wordKeys = $engine[2];
        foreach($wordKeys as $key){
            if(!empty($paramArr[$key])){
                $keyword = $paramArr[$key];
                break;
            }
        }
        $keyword = urldecode($keyword);

        //转编码
        if(!self::isUTF8($keyword)){
            $keyword = @iconv('gb2312', 'utf-8//IGNORE', $keyword);
        }
        //过滤空关键字
        if(empty($keyword)){
            return false;
        }

        return array(
            'engine' => $engine[0],
            'name' => $engine[1],
            'keyword' => $keyword
        );
    }

    //判断是否是utf-8码
    public static function isUTF8($string) {
        return preg_match('%^(?:
              [\x09\x0A\x0D\x20-\x7E]            # ASCII
            | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
            |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
            | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
            |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
            |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
            | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
            |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
        )*$%xs', $string);
    }
}

