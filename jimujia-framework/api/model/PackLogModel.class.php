<?php
/**
 * 主材包报名模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      主材包报名模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class PackLogModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_pack_log';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'pack_id' => 'int',
            'city_id' => 'int',
            'truename' => 'varchar',
            'mobile' => 'varchar',
            'community' => 'varchar',
            'house_type' => 'varchar',
            'house_area' => 'int',
            'owner_comment' => 'varchar',
            'adviser_id' => 'int',
            'adviser_name' => 'varchar',
            'add_time' => 'int',
            'is_purchase' => 'int',
            'is_virtual' => 'int',
            'msg_status' => 'int'
        );
    }

    //获取虚拟成交记录
    public function getVitualLogList($cityId, $limit = 10){
        $logList = $this->getAll('id,truename,pack_id,community,house_type,house_area,owner_comment,adviser_name',array(
            array('is_purchase', '=', 1),
            array('city_id', '=', $cityId),
            array('is_virtual', '=', 1)
        ),array('id'=>'desc'), 0, $limit);
        return $logList;
    }

    //获取虚拟成交记录的总数
    public function getVitualLogNum($cityId){
        $logNums = $this->getOne('count(id) as num',array(
            array('is_purchase', '=', 1),
            array('city_id', '=', $cityId),
            array('is_virtual', '=', 1)
        ));
        return $logNums;
    }

    //获取预定信息
    public function getLogInfo($packId, $mobile){
        return $this->getRow('id,add_time,msg_status', array(
            array('pack_id', '=', $packId),
            array('mobile', '=', $mobile)
        ));
    }

    //设置短信发送成功
    public function setLogMsgSuccess($logId){
        return $this->update(array('msg_status' => 1), array(
            array('id', '=', $logId)
        ));
    }

    //创建预定信息
    public function createLog($data){
        if(empty($data['mobile'])){
            return false;
        }
        $data['add_time'] = time();
        $logId = $this->insert($data);
        return $logId;
    }

    //获取预约体验人数
    public function getLogNumberByCityId($cityId, $id) {
        return $this->getOne('COUNT(id)', array(
            array('is_purchase', '=', 0),
            array('city_id', '=', $cityId),
            array('pack_id', '=', $id),
        ));
    }

    //获取预约信息
    public function getLogInfoByMobile($mobile) {
        return $this->getRow('id,add_time,msg_status', array(
            array('mobile', '=', $mobile)
        ));
    }
}
