<?php
/**
 * 广告位
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      广告位
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class AdPositionModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_ad_position';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'position_name' => 'varchar',
            'type' => 'enum'
        );
    }

    public function getAdPositionInfo($id){
        $positionInfo = $this->getRow('*', array(
            array('id', '=', $id)
        ));
        return $positionInfo;
    }
}
