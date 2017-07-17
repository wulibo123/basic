<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguTaskModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_task';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'task_id'=>'varchar',
            'project_id'=>'varchar',
            'group_id'=>'varchar',
            'stage_id'=>'varchar',
            'content'=>'varchar',
            'is_done'=>'tinyint',
            'visiable'=>'varchar',
            'note'=>'varchar',
            'due_date'=>'int',
            'update_time'=>'int',
            'create_time'=>'int',
            'add_time'=>'int',
        );
    }

    //根据阶段ID获取阶段下所有任务
    public function getTaskList($stageId, $time, $field = '*') {
        return $this->getAll($field, array(
            array('stage_id', '=', $stageId),
            array('add_time', '=', $time)
        ),array('is_done'=>'desc','due_date'=>'asc'));
    }

    //获取任务信息  已作废 20160523 by zhanglei
    public function getTaskInfo($taskId, $time, $field = 'content,note') {
        return $this->getRow($field, array(
            array('task_id', '=', $taskId),
            array('add_time', '=', $time)
        ));
    }

    //获取任务信息
    public function getTaskByID($taskId, $field = 'content,note') {
        return $this->getRow($field, array(
            array('task_id', '=', $taskId)
        ));
    }
}
