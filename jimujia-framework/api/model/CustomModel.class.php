<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class CustomModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_CUSTOM;
        $this->tableName      = 'c_transform';
        $this->dbMasterConfig = DBConfig::$SERVER_CUSTOM;
        $this->dbSlaveConfig  = DBConfig::$SERVER_CUSTOM;
        $this->fieldTypes     = array(
            'id'=>'int',
            'c_key'=>'varchar',
            'c_value'=>'text',
            'add_time'=>'timestamp',
        );
    }

    //根据key获取一条记录
    public function getValueBykey($key, $field = '*') {
        return $this->getAll($field, array(
            array('key','=',$key),
        ));
    }

    //创建一条记录
    public function createLog($data) {
        if(empty($data['c_key']) || empty($data['c_value'])) {
            return false;
        }
        $logId = $this->insert($data);
        return $logId;
    }
}
