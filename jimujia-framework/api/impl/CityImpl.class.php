<?php
require_once API_PATH . '/model/CityModel.class.php';
require_once API_PATH . '/impl/BaseImpl.class.php';

class CityImpl extends BaseImpl{

    //根据id获取城市信息
    public static function getCityInfoById($id){
        static $CITY_LIST = array();
        if(isset($CITY_LIST[$id])){
            return $CITY_LIST[$id];
        }
        $cityModel = new CityModel();
        $cityInfo = $cityModel->getCityInfoById($id);
        if(!$cityInfo){
            return null;
        }
        $CITY_LIST[$id] = $cityInfo;
        return $cityInfo;

        /*
        $cacheKey = __CLASS__ . '/' . __FUNCTION__ . '/' . $id;
        $cityInfo = self::_loadCache($cacheKey);

        if(!$cityInfo){
            $cityModel = new CityModel();
            $cityInfo = $cityModel->getCityInfoById($id);
            if(!$cityInfo){
                return null;
            }
            self::_saveCache($cacheKey, $cityInfo);
        }
        return $cityInfo;*/
    }

    //根据domain获取域名信息
    public static function getCityInfoByDomain($domain){
        static $CITY_LIST = array();
        if(isset($CITY_LIST[$domain])){
            return $CITY_LIST[$domain];
        }
        $cityModel = new CityModel();
        $cityInfo = $cityModel->getCityInfoByDomain($domain);
        if(!$cityInfo){
            return null;
        }
        $CITY_LIST[$domain] = $cityInfo;
        return $cityInfo;
        /*
        $cacheKey = __CLASS__ . '/' . __FUNCTION__ . '/' . $domain;
        $cityInfo = self::_loadCache($cacheKey);

        if(!$cityInfo){
            $cityModel = new CityModel();
            $cityInfo = $cityModel->getCityInfoByDomain($domain);
            if(!$cityInfo){
                return null;
            }
            self::_saveCache($cacheKey, $cityInfo);
        }
        return $cityInfo;*/
    }

    //获取所有信息
    public static function getCitylist(){
        static $CITY_LIST = array();
        if(!empty($CITY_LIST)){
            return $CITY_LIST;
        }
        $cityModel = new CityModel();
        $cityList = $cityModel->getCitylist();
        if(!$cityList){
            return null;
        }
        $CITY_LIST = $cityList;
        return $cityList;
        /*
        $cacheKey = __CLASS__ . '/' . __FUNCTION__ . '/all';
        $cityList = self::_loadCache($cacheKey);

        if(!$cityList){
            $cityModel = new CityModel();
            $cityList = $cityModel->getCitylist();
            if(!$cityList){
                return null;
            }
            self::_saveCache($cacheKey, $cityList);
        }
        return $cityList;*/
    }
}