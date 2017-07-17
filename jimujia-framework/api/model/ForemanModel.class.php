<?php
/**
 * 工长模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      工长模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class ForemanModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_foreman';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'username' => 'varchar',
            'city_id' => 'int',
            'photo' => 'varchar',
            'live_city' => 'varchar',
            'experience' => 'varchar',
            'service_area' => 'varchar',
            'main_case' => 'varchar',
            'work_years' => 'int',
            'owner_impression' => 'varchar',
            'is_warranty' => 'int',
            'is_skill' => 'int',
            'is_contract' => 'int',
            'status' => 'int',
            'display_order' => 'int'
        );
    }

    //获取工长信息
    public function getForemanInfoById($id, $field = '*'){
        return $this->getRow($field, array(
            array('id', '=', $id),
            array('status', '=', 1)
        ));
    }

    //获取工长列表
    public function getForemanList($cityId, $limit = 40){
        $foremanList = $this->getAll('id,username,photo,live_city,work_years,service_area,owner_impression,experience,main_case', array(
            array('status', '=', 1),
            array('city_id', '=', $cityId)
        ),array('display_order'=>'asc'), 0, $limit);
        return $foremanList;
    }
}
