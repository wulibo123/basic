<?php
/**
 * 活动商家模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MerchantActivityModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'gb_merchant';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id'=>'int',
            'activity_id'=>'int',
            'merchant_id'=>'int',
            'city_id'=>'int',
            'koubei'=>'varchar',
            'show_category'=>'varchar',
            'merchant_policy'=>'varchar',
            'is_mobile_show'=>'tinyint',
            'is_best'=>'tinyint',
            'add_time'=>'int',
            'display_order'=>'int',
        );
    }

    //获取活动所有参展商家新覅
    public function getActivityListById($activityId, $field = '*') {
        return $this->getAll($field, array(
            array('activity_id', '=', $activityId)
        ),array('display_order'=>'asc'));
    }

    //获取活动所有参展商家新覅FROM MOBILE
    public function getMerchantListByIdFromMobile($activityId, $field = '*') {
        return $this->getAll($field, array(
            array('activity_id', '=', $activityId),
            array('is_mobile_show', '=', 1)
        ),array('display_order'=>'asc'));
    }

    //获取某个商家的信息
    public function getMerchantInfoById($id, $field = '*'){
        return $this->getRow($field, array(
            array('id', '=', $id)
        ));
    }
}
