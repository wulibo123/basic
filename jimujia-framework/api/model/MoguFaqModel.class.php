<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguFaqModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_faq';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'truename'=>'varchar',
            'mobile'=>'char',
            'city_name'=>'varchar',
            'p'=>'varchar',
            'c'=>'varchar',
            'faq'=>'text',
            'is_solve'=>'tinyint',
            'add_time'=>'int'
        );
    }

    //新增一条数据
    public function createLog($data) {
        if(empty($data['mobile'])){
            return false;
        }
        $data['add_time'] = time();
        $logId = $this->insert($data);
        return $logId;
    }
}
