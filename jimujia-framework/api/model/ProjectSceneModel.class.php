<?php
/**
 * 工程现场模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      工程现场模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class ProjectSceneModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_project_scene';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'title' => 'varchar',
            'description' => 'varchar',
            'photo' => 'varchar',
            'address' => 'varchar',
            'area' => 'int',
            'period' => 'varchar',
            'nature' => 'varchar',
            'foreman_id' => 'int',
            'city_id' => 'int',
            'add_time' => 'int',
            'status' => 'int'
        );
    }

    //获取列表
    public function getSceneList($cityId, $limit = 2){
        $sceneList = $this->getAll('*', array(
            array('status', '=', 1),
            array('city_id', '=', $cityId)
        ),array('id'=>'desc'), 0, 4);

        return $sceneList;
    }

}
