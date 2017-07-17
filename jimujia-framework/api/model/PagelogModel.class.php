<?php
/**
 * 记录页面加载时间
 * @author    dubox
 * @since     2016.6.8
 * @desc
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class PagelogModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_log_page';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'spend_time'=>'int',    //用户停留时间
            'add_time'=>'int',
            'visitor_id'=>'varchar',
            'ip'=>'varchar',
            'isp'=>'varchar',
            'browser'=>'varchar',
            'platform'=>'varchar',
            'network_type'=>'varchar',
            'url'=>'text',
            'domain'=>'varchar',
            'site'=>'tinyint',
            'page'=>'varchar',
            'visit_id'=>'varchar',
            'ref'=>'varchar',
            'keyword'=>'varchar',
            'utm_source'=>'varchar',
            'utm_medium'=>'varchar',
            'utm_term'=>'varchar',
            'utm_content'=>'varchar',
            'utm_campaign'=>'varchar',
            'phone'=>'varchar',
            'type'=>'tinyint',
            'load_time'=>'int', //加载时间
            'page_num'=>'tinyint', //页数


        );
    }


    
    
}
