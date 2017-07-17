<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguOrderModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_order';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'order_sn'=>'varchar',
            'mobile'=>'char',
            'openid'=>'varchar',
            'city_name'=>'varchar',
            'pay_type'=>'enum',
            'amount'=>'decimal',
            'pay_status'=>'tinyint',
            'is_invalid'=>'tinyint',
            'add_time'=>'int',
            'pay_time'=>'int',
        );
    }

    //创建一条记录
    public function createLog($data) {
        if(empty($data['order_sn']) || empty($data['mobile']) || empty($data['city_name'])){
            return false;
        }
        return $this->insert($data);
    }

    //更新信息
    public function updateLog($id, $data){
        return $this->update($data, array(
            array('id', '=', $id)
        ));
    }

    //根据订单号更新信息
    public function updatePayment($order_sn, $data){
        return $this->update($data, array(
            array('order_sn', '=', $order_sn)
        ));
    }

    //根据手机号码查询
    public function getLogByMobile($mobile, $field = '*') {
        return $this->getRow($field, array(
            array('mobile',    '=', $mobile),
            array('is_invalid','=', 0),
            array('pay_status','=', 0)
        ));
    }

    //根据订单号查询订单信息
    public function getLogByOrderSn($order_sn, $field = '*'){
        return $this->getRow($field, array(
            array('order_sn',    '=', $order_sn),
            array('is_invalid','=', 0),
            array('pay_status','=', 0)
        ));
    }

    //根据订单号查询订单支付状态
    public function getLogStatusByOrderSn($order_sn, $field = 'pay_status'){
        return $this->getOne($field, array(
            array('order_sn',    '=', $order_sn),
            array('is_invalid','=', 0)
        ));
    }
}
