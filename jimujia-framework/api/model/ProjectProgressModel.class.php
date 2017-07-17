<?php
/**
 * 工程进度模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      工程进度模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class ProjectProgressModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_project_progress';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'progress_name' => 'varchar',
            'project_id' => 'int',
            'start_time' => 'int',
            'complete_time' => 'int',
            'note' => 'varchar',
            'status' => 'int',
            'display_order' => 'int'
        );
    }

    //获取进度列表
    public function getProgressList($projectId){
        $progressList = $this->getAll('*', array(
            array('project_id', '=', $projectId),
            array('status', '=', 1),
        ),array('display_order'=>'DESC'));

        return $progressList;
    }

}
