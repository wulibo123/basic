<?php
/**
 * 活动商家组件模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MerchantPluginsModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'gb_merchant_plugins';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id'=>'int',
            'activity_id'=>'int',
            'title_photo'=>'varchar',
            'height'=>'smallint',
            'bg_color'=>'char',
            'is_repeatx'=>'tinyint',
            'text_color'=>'char',
            'policy_color'=>'char',
            'nav_content'=>'varchar',
            'nav_bg_color'=>'char',
            'nav_hover_color'=>'char',
            'is_show'=>'tinyint',
            'mobile_brand_title'=>'varchar',
            'is_enable'=>'tinyint',
            'display_order'=>'int',
        );
    }

    //根据活动ID 获取当前插件基本信息
    public function getPluginsInfoById($activityId, $field = '*') {
        return $this->getRow($field, array(
            array('activity_id', '=', $activityId),
            array('is_enable', '=', 1)
        ));
    }
}
