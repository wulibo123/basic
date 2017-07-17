<?php
/**
 * 活动左侧导航组件模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class LeftPluginsModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'gb_left_plugins';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id'=>'int',
            'activity_id'=>'int',
            'city_id'=>'int',
            'photo'=>'varchar',
            'photo_text'=>'varchar',
            'bg_color'=>'char',
            'text_color'=>'char',
            'nav_hover_color'=>'char',
            'text_hover_color'=>'char',
            'nav_content'=>'text',
            'add_time'=>'int',
            'is_enable'=>'tinyint',
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
