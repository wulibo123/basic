<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguProjectModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_project';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'project_id'=>'varchar',
            'user_name'=>'varchar',
            'user_mobile'=>'char',
            'project_name'=>'varchar',
            'project_intro'=>'varchar',
            'create_time'=>'int',
            'update_time'=>'int',
            'add_time'=>'int',
        );
    }

    //根据手机号码和数据添加时间获取项目信息
    public function getProjectId($mobile, $time, $field = 'project_id') {
        return $this->getOne($field, array(
            array('user_mobile', '=', $mobile),
            array('add_time', '=', $time)
        ));
    } 
    
    
}
