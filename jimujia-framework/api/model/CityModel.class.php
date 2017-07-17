<?php
/**
 * 城市模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      城市模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class CityModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_city';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'city_name' => 'varchar',
            'domain' => 'varchar',
            'pinyin' => 'varchar',
            'first_char' => 'varchar',
            'seo_title' => 'varchar',
            'seo_keywords' => 'varchar',
            'seo_description' => 'varchar',
            'open_status' => 'int',
            'statistics_script' => 'varchar',
            'mobile_statistics_script' => 'varchar',
            'tencent_weibo' => 'varchar',
            'sina_weibo' => 'varchar',
            'display_order' => 'int',
            'show_customer' => 'int'
        );
    }

    public function getCityInfoById($id){
        return $this->getRow('*', array(
            array('id', '=', $id),
            array('open_status', '=', 1)
        ));
    }

    public function getCityInfoByDomain($domain){
        return $this->getRow('*', array(
            array('domain', '=', $domain),
            array('open_status', '=', 1)
        ));
    }

    public function getCitylist($field = '*'){
        return $this->getAll($field, array(
            array('open_status', '=', 1)
        ));
    }

}
