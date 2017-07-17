<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class GoodsActivityModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'gb_goods';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id'=>'int',
            'category_id'=>'mediumint',
            'goods_name'=>'varchar',
            'photo'=>'varchar',
            'display_order'=>'int',
            'activity_id'=>'mediumint',
            'original_price'=>'decimal',
            'price'=>'decimal',
            'remark'=>'varchar',
            'is_recommend'=>'tinyint',
            'limit_amount'=>'smallint',
            'status'=>'tinyint',
            'mobile_status'=>'tinyint',
            'create_time'=>'int',
            'mobile_display_order'=>'mediumint',
            'tag'=>'varchar',
        );
    }
}
