<?php
/**
 * 手机号码归属地模型
 * @author    初九 <527891885@qq.com>
 * @since     2014-8-22
 * @desc      手机号码归属地模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MobileAttributionModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_mobile_attribution';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'prefix'=>'char',
            'phone'=>'char',
            'p'=>'varchar',
            'c'=>'varchar',
            'isp'=>'varchar',
            'code'=>'int',
            'zip'=>'char',
            'types'=>'varchar'
        );
    }

    //获取预约信息
    public function getLogInfoByPhone($phone, $field = '*') {
        return $this->getRow($field, array(
            array('phone', '=', $phone)
        ));
    }
}
