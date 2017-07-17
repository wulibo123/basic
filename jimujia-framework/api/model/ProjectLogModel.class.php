<?php
/**
 * 工程预定模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      工程预定模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class ProjectLogModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_project_log';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'foreman_id' => 'int',
            'foreman_name' => 'varchar',
            'truename' => 'varchar',
            'sex' => 'int',
            'mobile' => 'varchar',
            'house_area' => 'int',
            'house_type' => 'varchar',
            'add_time' => 'int',
            'project_id' => 'int',
            'city_id' => 'int',
            'msg_status' => 'int',
            'is_virtual' => 'int',
            'service' => 'varchar'
        );
    }

    //获取预定记录信息
    public function getLogInfo($mobile, $foremanId){
        return $this->getRow('id,add_time,msg_status', array(
            array('foreman_id', '=', $foremanId),
            array('mobile', '=', $mobile)
        ));
    }

    public function setLogMsgSuccess($logId){
        return $this->update(array('msg_status' => 1), array(
            array('id', '=', $logId)
        ));
    }

    //创建日志
    public function createLog($data){
        if(empty($data['mobile'])){
            return false;
        }
        $data['add_time'] = time();
        $logId = $this->insert($data);
        return $logId;
    }

    //获取最新预定
    public function getVirtualLogList($cityId, $limit = 10){
        $logList = $this->getAll('truename,add_time,house_type,house_area,service', array(
            array('city_id', '=', $cityId),
            array('is_virtual', '=', 1)
        ), array('id'=>'desc'), 0, $limit);

        return $logList;
    }

    //根据手机号获取预定记录信息
    public function getLogInfoByMobile($mobile){
        return $this->getRow('id,add_time,msg_status', array(
            array('mobile', '=', $mobile)
        ));
    }
}
