<?php
/**
 * 装修顾问
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      装修顾问
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class AdviserModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_adviser';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'adviser_name' => 'varchar',
            'city_id' => 'int',
            'short_description' => 'varchar',
            'signature' => 'varchar',
            'qq' => 'varchar',
            'photo' => 'varchar',
            'status' => 'int',
            'display_order' => 'int'
        );
    }

    public function getAdviserList($cityId, $limit = 10){
        $adviserList = $this->getAll('id,adviser_name,short_description,signature,qq,photo', array(
            array('status', '=', 1),
            array('city_id', '=', $cityId)
        ), array('display_order'=>'desc', 'id'=>'desc'), 0, $limit);
        return $adviserList;
    }
}
