<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class SubscribeInfoModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_subscribe_info';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'name'=>'varchar',
            'contents'=>'varchar',
            'update_time'=>'int'
        );
    }

    //根据名称获取值
    public function getValueByName($name, $fields = 'contents,update_time'){
        return $this->getRow($fields, array(
            array('name', '=', $name)
        ));
    }

    //获取预约后台设置基数
    public function getBaseNum() {
        return $this->getOne('contents', array(
            array('name', '=', '预约基数')
        ));
    }

    //获取teambition数据更新时间
    public function getUpdateTime() {
        return $this->getOne('contents', array(
            array('name', '=', 'teambition_api_update_time')
        ));
    }

    //修改订购限制名额
    public function updateBuyNum($name){
        return $this->queryOne('UPDATE `mg_subscribe_info` SET `contents`=contents-1 WHERE name="buy_num"');
    }
}
