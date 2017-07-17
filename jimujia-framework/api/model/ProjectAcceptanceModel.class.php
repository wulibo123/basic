<?php
/**
 * 工程验收模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      工程模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class ProjectAcceptanceModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_project_acceptance';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'node_id' => 'int',
            'event_name' => 'varchar',
            'project_id' => 'int',
            'supervisor' => 'varchar',
            'report_time' => 'int',
            'conclusion' => 'int',
            'photo' => 'varchar',
            'remarks' => 'varchar'
        );
    }

    //获取验收的项目
    public function getAcceptanceList($projectId){
        $acceptanceList = $this->getAll('*', array(
            array('project_id', '=', $projectId)
        ),array('node_id'=>'asc'));

        return $acceptanceList;
    }

    //获取验收项目信息
    public function getAcceptanceInfo($id, $fields = '*'){
        $acceptanceInfo = $this->getRow($fields, array(
            array('id', '=', $id)
        ));
        return $acceptanceInfo;
    }

}