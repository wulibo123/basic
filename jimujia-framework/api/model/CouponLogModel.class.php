<?php
/**
 * 优惠券报名模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      优惠券报名模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class CouponLogModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_coupon_log';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'coupon_id' => 'int',
            'city_id' => 'int',
            'mobile' => 'varchar',
            'get_time' => 'int',
            'is_use' => 'int',
            'use_time' => 'int',
            'msg_status' => 'int'
        );
    }

    //获取日志记录
    public function getLogInfo($couponId, $mobile){
        return $this->getRow('id,get_time,msg_status', array(
            array('coupon_id', '=', $couponId),
            array('mobile', '=', $mobile)
        ));
    }

    //设置短信发送成功
    public function setLogMsgSuccess($logId){
        return $this->update(array('msg_status' => 1), array(
            array('id', '=', $logId)
        ));
    }

    //创建日志
    public function createLog($couponId, $mobile, $cityId){
        if($couponId < 1 || preg_match('/^1[34578]{1}\d{9}$/', $mobile) !== 1){
            return false;
        }

        $data = array(
            'coupon_id' => $couponId,
            'city_id' => $cityId,
            'mobile' => $mobile,
            'get_time' => time(),
            'is_use' => 0,
            'use_time' => 0
        );
        $logId = $this->insert($data);
        return $logId;
    }

    //获取领取记录数值
    public function getLogsQtByCoupon($couponId) {
        return $this->getOne('COUNT(id)', array(
            array('coupon_id',  '=', $couponId),
            array('msg_status', '=', 1)
        ));
    }
}
