<?php
/**
 * 商家评论模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      商家评论模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MerchantCommentModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_merchant_comment';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'merchant_id' => 'int',
            'username' => 'varchar',
            'tags' => 'varchar',
            'content' => 'varchar',
            'create_time' => 'int',
            'status' => 'int'
        );
    }
}
