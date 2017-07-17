<?php
/**
 * 红包组件模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class BonusPluginsModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'gb_bonus_plugins';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id'=>'int',
            'activity_id'=>'int',
            'city_id'=>'int',
            'title_photo'=>'varchar',
            'height'=>'smallint',
            'bg_color'=>'char',
            'text_color'=>'char',
            'use_rules'=>'varchar',
            'use_flow'=>'varchar',
            'subscribe_msg'=>'varchar',
            'get_msg'=>'varchar',
            'wechat_get_msg'=>'varchar',
            'wechat_subscribe_msg'=>'varchar',
            'mobile_title'=>'varchar',
            'is_repeatx'=>'tinyint',
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
