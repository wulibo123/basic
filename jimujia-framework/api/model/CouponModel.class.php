<?php
/**
 * 优惠券模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      优惠券模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class CouponModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_coupon';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'city_id' => 'int',
            'brand_id' => 'int',
            'merchant_id' => 'int',
            'category_id' => 'int',
            'coupon_type' => 'int',
            'amount' => 'int',
            'expire_time' => 'int',
            'introduce' => 'varchar',
            'photo' => 'varchar',
            'wechat_photo'=>'varchar',
            'status' => 'int',
            'display_order' => 'int'
        );
    }

    public function getCouponInfo($id, $fields = 'id,amount,coupon_type,expire_time'){
        return $this->getRow($fields, array(
            array('id', '=', $id),
            array('status', '=', 1)
        ));
    }

    public function getCouponList($cityId){
        $couponList = $this->getAll('id,expire_time,amount,photo,coupon_type,city_id,brand_id,merchant_id,introduce,category_id', array(
            array('status', '=', 1),
            array('city_id', '=', $cityId)
        ),array('display_order'=>'asc'));
        return $couponList;
    }

    public function getCouponNumByCategory($cityId, $categoryIds){
        $sql = 'SELECT COUNT(id) as qt,category_id FROM `tz_coupon` WHERE status=1 AND city_id='.$cityId.' AND category_id in ('.$categoryIds.') GROUP BY category_id';
        $couponNumList = $this->queryAll($sql);
        return $couponNumList;
    }
}
