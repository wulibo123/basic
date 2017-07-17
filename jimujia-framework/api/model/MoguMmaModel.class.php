<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguMmaModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_mma';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'mobile'=>'char',
            'mma'=>'char',
            'is_use'=>'tinyint',
            'is_msg'=>'tinyint',
            'add_time'=>'int',
        );
    }

    //创建一条记录
    public function createLog($data) {
        if(empty($data['mobile']) || empty($data['mma'])){
            return false;
        }
        $data['add_time'] = time();
        return $this->insert($data);
    }

    //更新信息
    public function updateLog($id, $data){
        return $this->update($data, array(
            array('id', '=', $id)
        ));
    }

    //根据手机号码更新信息
    public function updateMmaUse($mobile, $data){
        return $this->update($data, array(
            array('mobile', '=', $mobile)
        ));
    }

    //根据手机号码和城市查询
    public function getLogByMobile($mobile, $field = '*') {
        return $this->getRow($field, array(
            array('mobile',    '=', $mobile),
            array('is_use',    '=', 0)
        ));
    }

    //根据手机号码和城市，m码查询
    public function getLogByMobileMma($mobile, $mma, $field = '*') {
        return $this->getRow($field, array(
            array('mobile',    '=', $mobile),
            array('mma',       '=', $mma),
            array('is_use',    '=', 0)
        ));
    }
}
