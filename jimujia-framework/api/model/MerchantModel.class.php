<?php
/**
 * 商家模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      商家模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MerchantModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_merchant';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'merchant_name' => 'varchar',
            'brand_name' => 'varchar',
            'brand_logo' => 'varchar',
            'telephone' => 'varchar',
            'address' => 'varchar',
            'arrival_way' => 'varchar',
            'display_order' => 'int'
        );
    }

    public function getMerchantInfoById($id, $field = 'id,merchant_name,telephone,address,arrival_way'){
        return $this->getRow($field, array(
            array('id', '=', $id)
        ));
    }

    public function getMerchantFieldValue($id, $field = '*') {
        return $this->getOne($field, array(
            array('id', '=', $id)
        ));
    }
}
