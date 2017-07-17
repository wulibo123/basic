<?php
/**
 * 字典模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      字典模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class DictModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_dict';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'dict_name' => 'varchar',
            'variable_name' => 'varchar',
            'display_order' => 'int'
        );
    }

    public function getTypeByName($name) {
        return $this->getOne('id', array(
            array('variable_name', '=' , $name)
        ));
    }
}
