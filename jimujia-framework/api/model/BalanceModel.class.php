<?php
/**
 * 蘑菇装修预购微信用到
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2015-2-5
 * @desc      蘑菇装修预购微信用到
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class BalanceModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WECHAT;
        $this->tableName      = 'mp_mg_balance';
        $this->dbMasterConfig = DBConfig::$SERVER_WECHAT;
        $this->dbSlaveConfig  = DBConfig::$SERVER_WECHAT;
        $this->fieldTypes     = array(
            'id' => 'int',
            'fromuser' => 'varchar',
            'balance' => 'decimal',
            'time' => 'datetime'
        );
    }

    public function newBalance($data){
        $data['time'] = date('Y-m-d H:i:s');
        $bid = $this->insert($data);
        return $bid;
    }
}