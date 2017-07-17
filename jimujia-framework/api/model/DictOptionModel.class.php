<?php
/**
 * 字典选项模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      字典选项模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class DictOptionModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_dict_option';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'dict_id' => 'int',
            'field_name' => 'varchar',
            'field_value' => 'varchar',
            'display_order' => 'int'
        );
    }

    public function getOptionName($dictId, $optionValue){
        return $this->getOne('field_name', array(
            array('dict_id', '=', $dictId),
            array('field_value', '=', $optionValue)
        ));
    }
}
