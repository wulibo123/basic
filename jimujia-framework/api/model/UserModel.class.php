<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class UserModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_user';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'username' =>'varchar',
            'openid'=>'varchar',
            'mobile'=>'char',
            'headimg'=>'varchar',
            'add_time'=>'int',
        );
    }

    //新增一条记录
    public function createLog($data) {
        if(empty($data['mobile'])){
            return false;
        }
        $data['add_time'] = time();
        $logId = $this->insert($data);
        return $logId;
    }
    
    //根据手机号码
    public function getLogInfoByMobile($mobile, $field= '*'){
        return $this->getRow($field, array(
            array('mobile', '=', $mobile)
        ));
    }

    //根据opendi
    public function getLogInfoByOpenid($openid, $field = '*') {
        return $this->getRow($field, array(
            array('openid', '=', $openid)
        ));
    }

    //重新绑定手机
    public function rebindByMobile($id, $mobile){
        return $this->update(array('mobile' => $mobile), array(
            array('id', '=', $id)
        ));
    }
}
