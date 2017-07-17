<?php
require_once API_PATH . '/model/CategoryActivityModel.class.php';
require_once API_PATH . '/impl/BaseImpl.class.php';

class ActivityCategoryImpl extends BaseImpl{

    //根据parentId获取所有子分类
    public static function getCategoryInfoByParentId($parentId){
        $cacheKey = __CLASS__ . '/' . __FUNCTION__ . '/' . $parentId;
        $categoryInfo = self::_loadCache($cacheKey);

        if(!$categoryInfo){
            $categoryModel = new CategoryActivityModel();
            $categoryInfo = $categoryModel->getCategoryInfoByParentId($parentId);
            if(!$categoryInfo){
                return null;
            }
            self::_saveCache($cacheKey, $categoryInfo);
        }
        return $categoryInfo;
    }
}