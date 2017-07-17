<?php
/**
 * 活动红包模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class BonusActivityModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'gb_bonus';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id'=>'int',
            'activity_id'=>'int',
            'city_id'=>'int',
            'bonus_name'=>'varchar',
            'bonus_amount'=>'decimal',
            'use_condition'=>'varchar',
            'grant_qty'=>'smallint',
            'yet_get_qty'=>'smallint',
            'is_pc_show'=>'tinyint',
            'is_mobile_show'=>'tinyint',
            'is_enable'=>'tinyint',
            'display_order'=>'int',
        );
    }

    //获取活动所有红包根据ID PC
    public function getActivityListById($activityId, $field = '*') {
        return $this->getAll($field, array(
            array('activity_id', '=', $activityId),
            array('is_pc_show', '=', 1),
            array('is_enable', '=', 1)
        ),array('display_order'=>'asc'));
    }

    //获取活动所有红包根据活动ID mobile
    public function getBonusListByIdFromMobile($activityId, $field = '*') {
        return $this->getAll($field, array(
            array('activity_id', '=', $activityId),
            array('is_mobile_show', '=', 1),
            array('is_enable', '=', 1)
        ),array('display_order'=>'asc'));
    }

    //根据红包ID获取红包信息
    public function getBonusInfoById($id, $field = '*') {
        return $this->getRow($field, array(
            array('id', '=', $id),
            array('is_enable', '=', 1)
        ));
    }

    //修改红包发放数量自减一
    public function updateInfo($id) {
        $data['grant_qty'] = 'IF(`grant_qty`<1, 0, `grant_qty`-1)';
        $data['yet_get_qty'] = '`yet_get_qty`+1';
        return $this->update($data, array(
            array('id', '=', $id),
            array('is_enable', '=', 1)
        ));
    }

    //获取信息根据红包ID
    public function getInfoById($id, $field = 'grant_qty as num,activity_id'){
        return $this->getRow($field, array(
            array('id', '=', $id),
            array('is_enable', '=', 1)
        ));
    }
}
