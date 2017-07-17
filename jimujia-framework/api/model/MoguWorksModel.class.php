<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguWorksModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_works';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'file_id'=>'varchar',
            'file_name'=>'varchar',
            'file_type'=>'enum',
            'file_size'=>'mediumint',
            'project_id'=>'varchar',
            'task_id'=>'varchar',
            'thumbnail'=>'varchar',
            'thumbnail_url'=>'varchar',
            'download_url'=>'varchar',
            'image_width'=>'varchar',
            'image_height'=>'varchar',
            'create_time'=>'int',
            'update_time'=>'int',
            'preview_url'=>'varchar',
            'add_time'=>'int',
        );
    }
    //根据任务ID获取关联文件  已作废 20160523 by zhanglei
     public function getWorksList($linIds, $time, $field = '*') {
        return $this->getAll($field, array(
            array('file_id', 'in', explode(',', $linIds)),
            array('add_time', '=', $time)
        ));
    }


    //根据任务ID获取关联文件  已作废 20160523 by zhanglei
    public function getWorksListByLid($linIds, $field = '*') {
        return $this->getAll($field, array(
            array('file_id', 'in', explode(',', $linIds))
        ));
    }

    //根据任务Id获取是否有关联文件
    /*public function getWorksIsExist($taskId, $time) {
        return $this->getOne('COUNT(id)', array(
            array('task_id', '=', $taskId),
            array('add_time', '=', $time)
        ));
    }*/
}
