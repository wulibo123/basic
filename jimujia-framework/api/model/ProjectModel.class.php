<?php
/**
 * 工程模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      工程模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class ProjectModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_project';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'user_id' => 'int',
            'foreman_id' => 'int',
            'log_id' => 'int',
            'city_id' => 'int',
            'owner_name' => 'varchar',
            'mobile' => 'varchar',
            'contract_no' => 'varchar',
            'photo' => 'varchar',
            'address' => 'varchar',
            'community' => 'varchar',
            'house_type' => 'varchar',
            'house_area' => 'int',
            'period' => 'int',
            'progress_percent' => 'int',
            'complete_time' => 'int',
            'owner_comment' => 'varchar',
            'owner_comment_link' => 'varchar',
            'owner_video' => 'varchar',
            'add_time' => 'int',
            'status' => 'int',
            'display_order' => 'int'
        );
    }

    //根据用户id获取工程
    public function getProjectInfoByUserId($userId, $field = '*'){
        return $this->getRow($field, array(
            array('user_id', '=', $userId)
        ));
    }

    //获取有视频评价的工程
    public function getVideoCommentList($cityId, $limit = 3){
        $commentList = $this->getAll('id,owner_video', array(
            array('status', '=', 1),
            array('city_id', '=', $cityId),
            array('owner_video', '!=', '')
        ),array('display_order'=>'asc'), 0, $limit);

        return $commentList;
    }

    //获取评价的工程
    public function getCommentList($cityId, $limit = 3, $offset = 0){
        $commentList = $this->getAll('*', array(
            array('status', '=', 1),
            array('city_id', '=', $cityId),
            array('photo', '!=', '')
        ),array('display_order'=>'asc'), $offset, $limit);

        return $commentList;
    }

    //获取所有评价总数
    public function getCommentCount($cityId){
        return $this->getOne('count(id)', array(
            array('status', '=', 1),
            array('city_id', '=', $cityId),
            array('photo', '!=', '')
        ));
    }

}
