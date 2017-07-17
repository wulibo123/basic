<?php
/**
 * 城市体验店模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      城市体验店模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class CityStoreModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_city_store';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'city_id' => 'int',
            'address' => 'varchar',
            'opening_time' => 'varchar',
            'telephone' => 'varchar',
            'arrival_way' => 'varchar',
            'map_photo' => 'varchar',
            'map_url' => 'varchar'
        );
    }

    public function getStoreInfoByCityId($cityId){
        return $this->getRow('*', array(
            array('city_id', '=', $cityId)
        ));
    }

}
