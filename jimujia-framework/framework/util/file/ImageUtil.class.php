<?php
/*i
 * @brief 图片处理
 * move by gaosk<gaoshikao@qq.com> 2011.6.1
 * @todo 移到图片类
 */
require_once CONF_PATH . '/server/SystemConfig.class.php';

class ImageUtil{

    //格式化图片url
    public static function getFormatImageUrl($image, $option = array(), $domain = 1){
        $replacement = "tmp/\$1";
        if(empty($image)) return 'http://'.SystemConfig::DOMAIN_IMG.'/images/no_image.jpg';

        if(is_array($option) and count($option)){
            //width宽度像素，0表示按照高度要求，等比例缩放
            $replacement .= '_'.$option['width'];
            //height 高度像素，0表示按照宽度要求，等比例缩放
            $replacement .= '-'.$option['height'];
            //cut裁剪
            if($option['crop']){
                $replacement .= 'c';
            }
            //quality图像质量0-9，分10级，9质量最好，0质量最差
            $replacement .= '_'.$option['quality'];
            //version当前缩略图策略的版本号，递增。用于控制缩略图及水印的策略
            $replacement .= '-0';
            //.jpg .png ...
            $pattern = "/([^\/]+)(.[a-z]{3,})$/i";
            $replacement .= "\$2";
            $image = ($domain ? 'http://'.SystemConfig::DOMAIN_IMG.'/' : '') . preg_replace($pattern,$replacement,$image);

            return $image;
        } else {
            return ($domain ? 'http://'.SystemConfig::DOMAIN_IMG.'/' : '') . $image;
        }
    }

    //获取原始图片
    public static function getOriginalImageUrl($image){
        if($image){
            $pattern = "/\/tmp\/([0-9a-zA-Z]+)[\w-]+(\.[a-z]{3,})$/i";
            $replacement = "/\$1\$2";
            $image = preg_replace($pattern,$replacement,$image);
            return $image;
        }
    }
}
