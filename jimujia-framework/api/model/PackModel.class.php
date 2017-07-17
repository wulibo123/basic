<?php
/**
 * 主材包模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-7-17
 * @desc      主材包模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class PackModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_pack';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'pack_name' => 'varchar',
            'description' => 'varchar',
            'tag' => 'varchar',
            'origin_price_start' => 'decimal',
            'origin_price_end' => 'decimal',
            'price_start' => 'decimal',
            'price_end' => 'decimal',
            'sale_number' => 'int',
            'comment_number' => 'int',
            'city_id' => 'int',
            'desc_1' => 'int',
            'desc_2' => 'int',
            'desc_3' => 'int',
            'desc_4' => 'int',
            'desc_5' => 'int',
            'desc_6' => 'int',
            'desc_7' => 'int',
            'desc_8' => 'int',
            'price_list' => 'varchar',
            'status' => 'int',
            'display_order' => 'int'
        );
    }

    public function getPackList($cityId){
        $packList = $this->getAll('id,pack_name,template,description,tag,price_start,sale_number,comment_number,price_list', array(
            array('status', '=', 1),
            array('city_id', '=', $cityId)
        ),array('display_order'=>'desc'));
        return $packList;
    }

    function getPackInfoById($id, $field = '*'){
        return $this->getRow($field, array(
            array('id', '=', $id),
            array('status', '=', 1)
        ));
    }
}
