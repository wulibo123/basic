<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguStageModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_stage';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'stage_id'=>'varchar',
            'group_id'=>'varchar',
            'stage_name'=>'varchar',
            'stage_order'=>'varchar',
            'total_count'=>'int',
            'add_time'=>'int',
        );
    }

    //根据项目Id 和 分组ID 以及添加时间获取阶段信息
    public function getStageList($groupId, $time, $field = '*') {
        return $this->getAll($field, array(
            array('group_id', '=', $groupId),
            array('add_time', '=', $time)
        ));
    } 

    //根据项目Id 和 分组ID 以及添加时间获取阶段信息  已作废 20160523 by zhanglei
     public function getStageFieldValue($stageId, $time, $field = 'stage_name') {
        return $this->getOne($field, array(
            array('stage_id', '=', $stageId),
            array('add_time', '=', $time)
        ));
    }


    //根据项目Id 和 分组ID 以及添加时间获取阶段信息
    public function getStageFieldValueBySid($stageId, $field = 'stage_name') {
        return $this->getOne($field, array(
            array('stage_id', '=', $stageId)
        ));
    }
}
