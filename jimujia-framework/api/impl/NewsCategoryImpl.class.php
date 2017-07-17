<?php
require_once API_PATH . '/model/NewsCategoryModel.class.php';
require_once API_PATH . '/impl/BaseImpl.class.php';

class NewsCategoryImpl extends BaseImpl{

    //根据id获取分类信息
    public static function getCategoryInfoById($id){
        $cacheKey = __CLASS__ . '/' . __FUNCTION__ . '/' . $id;
        $categoryInfo = self::_loadCache($cacheKey);

        if(!$categoryInfo){
            $categoryModel = new NewsCategoryModel();
            $categoryInfo = $categoryModel->getCategoryInfoById($id);
            if(!$categoryInfo){
                return null;
            }
            self::_saveCache($cacheKey, $categoryInfo);
        }
        return $categoryInfo;
    }
}