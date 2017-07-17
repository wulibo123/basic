<?php
/**
 * 预约模型
 * @author    初九 <527891885@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class SubscribeModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_subscribe';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'user_id'=>'int',
            'truename'=>'varchar',
            'sex'=>'tinyint',
            'mobile'=>'char',
            'phone'=>'char',
            'p'=>'varchar',
            'c'=>'varchar',
            'address'=>'varchar',
            'area'=>'decimal',
            'photo'=>'varchar',
            'shi'=>'varchar',
            'ting'=>'varchar',
            'chu'=>'varchar',
            'wei'=>'varchar',
            'yangtai'=>'varchar',
            'style'=>'tinyint',
            'price'=>'decimal',
            'house'=>'varchar',
            'city_name'=>'varchar',
            'city_area'=>'varchar',
            'add_time'=>'int',
            'is_subscribe'=>'tinyint',
            'is_process'=>'tinyint',
            'is_msg'=>'tinyint',
            'is_verify'=>'tinyint',
            'order_sn' => 'varchar',
            'pay_stage' => 'tinyint',
            'payment_type' => 'varchar',
            'payment_status' => 'int',
            'launch_time' => 'int',
            'ip' => 'varchar',
            'source' => 'enum',
            'request_url'=>'varchar',
            'yugou_referer'=>'varchar',
            'zx_type'=>'varchar',
            'house_type'=>'varchar',
            'launch_type'=>'varchar',
            'product'=>'varchar',
            'date'=>'date',
            'cstart_time' =>'int',
            'village' =>'varchar',
            'customer_remarks' =>'varchar',
        );
    }

    //新增一条数据
    public function createLog($data) {
        if(empty($data['mobile'])){
            return false;
        }
        $data['add_time'] = time();
        $logId = $this->insert($data);
        return $logId;
    }

    //更新信息
    public function updateLog($id, $data){
        return $this->update($data, array(
            array('id', '=', $id)
        ));
    }

    //设置短信发送成功
    public function setLogMsgSuccess($logId){
        return $this->update(array('is_msg' => 1), array(
            array('id', '=', $logId)
        ));
    }

    //获取预约信息
    public function getLogInfoByMobile($mobile, $field = '*') {
        return $this->getRow($field, array(
            array('mobile', '=', $mobile),
            array('is_process', '=', 0)
        ));
    }

    public function  getYuyueInfoByMobile($mobile, $cityName = '', $is_subscribe = '', $field = '*'){
        $where = array(
            array('mobile', '=', $mobile),
            //array('add_time', '>', strtotime('today')),     //修改重复报名逻辑为一个号码一天只能报一次  dubox 2016.3.22
            //array('city_name', '=', $cityName),
            //array('is_subscribe', '=', $is_subscribe),
            //array('is_process', '=', 0)
        );
        /***    注释于修改重复报名逻辑为一个号码一天只能报一次  dubox 2016.3.22
        if($is_subscribe == 1 or $is_subscribe == 7){
        $where[3] = array('or'=>array(
        array('is_subscribe', '=', 1),
        array('is_subscribe', '=', 7)
        )
        );
        }
         * **/
        return $this->getRow($field, $where ,array('add_time' => 'desc') );  //修改为查时间最新的一条   dubox 2016.4.12
    }
    //所有城市是否预约过
    public function getInfoByMobile($mobile, $field = '*') {
        return $this->getRow($field, array(
            array('mobile', '=', $mobile),
            array('is_subscribe', '=', 1),
            array('is_process', '=', 0)
        ));
    }

    //获取预约信息根据手机号和城市
    public function getLogInfoByMobileAndCity($mobile, $cityName, $field = '*') {
        return $this->getRow($field, array(
            array('mobile', '=', $mobile),
            array('city_name', '=', $cityName),
            array('is_process', '=', 0),
            array('or'=>array(
                array('is_subscribe', '=', 1),
                array('is_subscribe', '=', 7)
            )
            )
        ));
    }

    //获取报名信息
    public function getLogApplyInfoByMobile($mobile, $cityName, $field = '*') {
        return $this->getRow($field, array(
            array('mobile', '=', $mobile),
            array('city_name', '=', $cityName),
            array('is_subscribe', '=', 2),
            array('is_process', '=', 0)
        ));
    }

    //获取量房信息
    public function getAmountRoomInfoByMobile($mobile, $cityName, $field = '*') {
        return $this->getRow($field, array(
            array('mobile', '=', $mobile),
            array('city_name', '=', $cityName),
            array('is_subscribe', '=', 4),
            array('is_process', '=', 0)
        ));
    }

    //获取报价信息
    public function getQuotedPriceInfoByMobile($mobile, $cityName, $field = '*') {
        return $this->getRow($field, array(
            array('mobile', '=', $mobile),
            array('city_name', '=', $cityName),
            array('is_subscribe', '=', 3),
            array('is_process', '=', 0)
        ));
    }

    //获取样板间信息
    public function getStyleModelInfoByMobile($mobile, $cityName, $field = '*') {
        return $this->getRow($field, array(
            array('mobile', '=', $mobile),
            array('city_name', '=', $cityName),
            array('is_subscribe', '=', 5),
            array('is_process', '=', 0)
        ));
    }

    //获取参观样板间信息
    public function getVisitStyleModelInfoByMobile($mobile, $cityName, $field = '*') {
        return $this->getRow($field, array(
            array('mobile', '=', $mobile),
            array('city_name', '=', $cityName),
            array('is_subscribe', '=', 6),
            array('is_process', '=', 0)
        ));
    }

    //获取预约信息
    public function getLogInfoById($id) {
        return $this->getRow('*', array(
            array('id', '=', $id)
        ));
    }

    //获取预约总数
    public function getLogCount() {
        return $this->getOne('MAX(id)');
    }

    //更新订单状态根据订单号
    public function uopdatePayStatus($orderSN, $data){
        return $this->update($data, array(
            array('order_sn', '=', $orderSN)
        ));
    }

    //根据订单号查询订单状态
    public function getOrderStatus($orderSN) {
        return $this->getOne('payment_status', array(
            array('order_sn', '=', $orderSN)
        ));
    }

    //获取单位时间的报名记录
    public function getEnrollAll($startTime,$endTime, $field = '*') {
        return $this->getAll($field, array(
            array('add_time', '>=', $startTime),
            array('add_time', '<=', $endTime)
        ),array('id'=>'desc'));
    }
}
