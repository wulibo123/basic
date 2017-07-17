<?php
/**
 * 活动投票模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      活动爆款商品表
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class VotingActivityModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'gb_voting';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id'=>'int',
            'activity_id'=>'int',
            'city_id'=>'int',
            'voting_name'=>'varchar',
            'voting_photo'=>'varchar',
            'base_num'=>'smallint',
            'voting_num'=>'smallint',
            'display_order'=>'int',
        );
    }

    //获取活动所有投票根据ID
    public function getActivityListById($activityId, $field = '*') {
        return $this->getAll($field, array(
            array('activity_id', '=', $activityId)
        ));
    }

    //获取信息根据ID
    public function getInfoById($id, $field = 'activity_id'){
        return $this->getRow($field, array(
            array('id', '=', $id)
        ));
    }

    //修改红包发放数量自减一
    public function updateInfo($id) {
        $data['voting_num'] = '`voting_num`+1';
        return $this->update($data, array(
            array('id', '=', $id)
        ));
    }
}
