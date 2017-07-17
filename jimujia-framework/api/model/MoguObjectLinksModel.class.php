<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguObjectLinksModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_object_links';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'task_id'=>'varchar',
            'link_id'=>'varchar',
            'add_time'=>'int',
        );
    }

    //根据阶段taskid获取阶段下所有文件ID   已作废 20160523 by zhanglei
     public function getLinkIdsList($taskId, $time, $field = 'link_id') {
        return $this->getOne('GROUP_CONCAT('.$field.')', array(
            array('task_id', '=', $taskId),
            array('add_time', '=', $time)
        ),array('is_done'=>'desc','due_date'=>'asc'));
    }


    //根据阶段taskid获取阶段下所有文件ID
    public function getLinkIdsListByTaskID($taskId, $field = 'link_id') {
        return $this->getOne('GROUP_CONCAT('.$field.')', array(
            array('task_id', '=', $taskId)
        ),array('is_done'=>'desc','due_date'=>'asc'));
    }

    //根据任务Id获取是否有关联文件 已作废 20160523 by zhanglei
  public function getLinkIdsExist($taskId, $time) {
        return $this->getOne('COUNT(link_id)', array(
            array('task_id', '=', $taskId),
            array('add_time', '=', $time)
        ));
    }


    
}
