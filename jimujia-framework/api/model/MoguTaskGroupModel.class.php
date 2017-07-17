<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguTaskGroupModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_task_group';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'group_id'=>'varchar',
            'group_title'=>'varchar',
            'project_id'=>'varchar',
            'creatorld'=>'varchar',
            'group_intro'=>'text',
            'create_time'=>'int',
            'update_time'=>'int',
            'add_time'=>'int',
        );
    }

    //获取任务分组Id 只取第一个
     public function getTaskGroupId($projectId, $time, $field = 'group_id') {
        return $this->getOne($field, array(
            array('project_id', '=', $projectId),
            array('add_time', '=', $time)
        ));
    } 
}
