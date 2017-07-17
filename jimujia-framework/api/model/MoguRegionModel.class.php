<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguRegionModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_region';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'name'=>'varchar',
            'level'=>'tinyint',
            'parentId'=>'int',
            'showOrder'=>'smallint',
            'openStatus'=>'tinyint',
        );
    }

    //根据parentId获取城市信息
    public function getListByPid($parentId, $fields = '*') {
        return $this->getAll($fields, array(
            array('parentId', '=', $parentId),
            array('openStatus', '=', 1)
        ),array('showOrder'=>'asc'));
    }

    //获取所有城市
    public function getCityList($fields='*') {
        return $this->getAll($fields, array(
            array('openStatus', '=', 1)
        ),array('showOrder'=>'asc'));
    }
}
