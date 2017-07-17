<?php
/**
 * 记录页面加载时间
 * @author    dubox
 * @since     2016.6.8
 * @desc
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class LogvisitModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_log_visit';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'visitor_id'=>'varchar',

        );
    }


    
    
}
