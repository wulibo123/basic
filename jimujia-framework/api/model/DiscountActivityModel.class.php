<?php
/**
 * 活动特价商品表
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      活动爆款商品表
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class DiscountActivityModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'gb_discount';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id'=>'int',
            'activity_id'=>'int',
            'city_id'=>'int',
            'merchant_id'=>'int',
            'goods_name'=>'varchar',
            'description'=>'varchar',
            'goods_photo'=>'varchar',
            'goods_tag'=>'varchar',
            'primary_price'=>'decimal',
            'group_price'=>'decimal',
            'unit'=>'varchar',
            'is_index_show'=>'tinyint',
            'is_pc_show'=>'tinyint',
            'is_mobile_show'=>'tinyint',
            'is_best'=>'tinyint',
            'apply_num'=>'smallint',
            'display_order'=>'int',
        );
    }

    //获取活动所有特价根据ID
    public function getActivityListById($activityId, $field = '*') {
        return $this->getAll($field, array(
            array('activity_id', '=', $activityId),
            array('is_pc_show', '=', 1)
        ),array('display_order'=>'asc'));
    }

    //获取活动所有特价根据ID
    public function getDisCountListByIdFromMoble($activityId, $field = '*') {
        return $this->getAll($field, array(
            array('activity_id', '=', $activityId),
            array('is_mobile_show', '=', 1)
        ),array('display_order'=>'asc'));
    }

    //根据ID获取特价商品信息
    public function getDisCountGoodsInfoById($id, $field = '*') {
        return $this->getRow($field, array(
            array('id', '=', $id),
        ));
    }

    //获取信息根据ID
    public function getInfoById($id, $field = 'activity_id'){
        return $this->getRow($field, array(
            array('id', '=', $id)
        ));
    }

    //修改爆款发放数量自减一
    public function updateInfo($id) {
        $data['apply_num'] = '`apply_num`+1';
        return $this->update($data, array(
            array('id', '=', $id)
        ));
    }
}
