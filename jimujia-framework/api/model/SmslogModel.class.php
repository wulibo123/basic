<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class SmslogModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_sms_log';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'sms_telephone'=>'varchar',
            'sms_message'=>'varchar',
            'sms_status'=>'int',
            'addtime'=>'int',
        );
    }

    //根据名称获取值
    public function addsmslog($data){
        return $this->insert($data);
    }

    //修改订购限制名额
    public function updatesmslog($id,$data){
        return $this->update($data, array(
            array('id', '=', $id)
        ));
    }
    
    //判断30秒短信是否重复发送
    public function pdsmslog($telephone,$msg,$field = '*'){
    	$time = time()-30;
    	
    	$arr = $this->getRow($field, array(
            array('sms_telephone', '=', $telephone),
    		array('sms_message', '=', $msg),
            array('sms_status', '=', 2),
    		array('addtime', '>', $time)
        ));
    	if($arr){
    		return true;
    	}else{
    		return false;
    	}
    }
    
    
}
