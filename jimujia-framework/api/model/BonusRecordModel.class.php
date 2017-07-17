<?php
/**
 * 红包领取记录模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class BonusRecordModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'gb_bonus_record';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id'=>'int',
            'activity_id'=>'int',
            'city_id'=>'int',
            'bonus_id'=>'int',
            'record_status'=>'tinyint',
            'mobile'=>'char',
            'add_time'=>'int',
            'source'=>'tinyint',
            'ip'=>'bigint',
        );
    }

    //新增一条记录
    public function createLog($data) {
        if(empty($data['mobile']) || empty($data['activity_id']) || empty($data['bonus_id'])){
            return false;
        }
        $data['add_time'] = time();
        $logId = $this->insert($data);
        return $logId;
    }

    //根据ID 和手机 获取领取记录
    public function getCount($bonusId, $mobile){
        return $this->getOne(COUNT('id'), array(
            array('bonus_id', '=', $bonusId),
            array('mobile', '=', $mobile)
        ));
    }
}
