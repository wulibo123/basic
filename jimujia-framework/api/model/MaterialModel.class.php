<?php
/**
 * 辅料模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-7-17
 * @desc      辅料模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MaterialModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_material';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'title' => 'varchar',
            'photo' => 'varchar',
            'brand_name' => 'varchar',
            'spec' => 'varchar',
            'produce_place' => 'varchar',
            'city_id' => 'int',
            'status' => 'int'
        );
    }

    public function getMaterialList($cityId){
        $materialList = $this->getAll('*', array(
            array('status', '=', 1),
            array('city_id', '=', $cityId)
        ),array('id'=>'desc'));

        return $materialList;
    }

}
