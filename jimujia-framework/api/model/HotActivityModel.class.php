<?php
/**
 * 活动爆款商品表
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      活动爆款商品表
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class HotActivityModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'gb_hot';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id'=>'int',
            'activity_id'=>'int',
            'city_id'=>'int',
            'merchant_id'=>'int',
            'goods_name'=>'varchar',
            'description'=>'varchar',
            'photo'=>'varchar',
            'panic_buying'=>'decimal',
            'group_buying'=>'decimal',
            'unit'=>'varchar',
            'issue_qty'=>'smallint',
            'panic_buying_qty'=>'smallint',
            'panic_buying_time'=>'varchar',
            'is_pc_show'=>'tinyint',
            'is_mobile_show'=>'tinyint',
            'display_order'=>'int',
            'mobile_display_order'=>'int',
        );
    }

    //获取活动所有爆款根据ID
    public function getActivityListById($activityId, $field = '*') {
        return $this->getAll($field, array(
            array('activity_id', '=', $activityId),
            array('is_pc_show', '=', 1)
        ),array('display_order'=>'asc'));
    }

    //获取活动所有爆款根据ID
    public function getHotListByIdFromMobile($activityId, $field = '*') {
        return $this->getAll($field, array(
            array('activity_id', '=', $activityId),
            array('is_mobile_show', '=', 1)
        ),array('mobile_display_order'=>'asc'));
    }

    //根据ID获取爆款商品信息
    public function getHotGoodsInfoById($id, $field = '*') {
        return $this->getRow($field, array(
            array('id', '=', $id)
        ));
    }

    //修改爆款发放数量自减一
    public function updateInfo($id) {
        $data['issue_qty'] = 'IF(`issue_qty`<1, 0, `issue_qty`-1)';
        $data['panic_buying_qty'] = '`panic_buying_qty`+1';
        return $this->update($data, array(
            array('id', '=', $id)
        ));
    }

    //获取一条信息
    public function getInfoById($id, $field = 'issue_qty as num,activity_id'){
        return $this->getRow($field, array(
            array('id', '=', $id)
        ));
    }
}
