<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguProvinceModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_province';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'code'=>'varchar',
            'name'=>'varchar'
        );
    }

    //获取所有省份
    public function getProvinceList($fields='*') {
        return $this->getAll($fields);
    }
}
