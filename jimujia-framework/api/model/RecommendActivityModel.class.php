<?php
/**
 * 活动推荐活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      活动爆款商品表
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class RecommendActivityModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'gb_recommend';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id'=>'int',
            'activity_id'=>'int',
            'city_id'=>'int',
            'reason_first'=>'varchar',
            'reason_two'=>'varchar',
            'reason_three'=>'varchar',
            'monitor_link'=>'varchar',
            'activity_ids'=>'varchar',
            'display_order'=>'int',
        );
    }

    //根据活动ID 获取当前插件基本信息
    public function getPluginsInfoById($activityId, $field = '*') {
        return $this->queryAll('SELECT '.$field.' FROM `gb_recommend` WHERE FIND_IN_SET('.$activityId.',activity_ids)');
    }
}
