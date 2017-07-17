<?php
/**
 * 友情链接
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      友情链接
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class LinkModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_link';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'city_id' => 'int',
            'name' => 'varchar',
            'link' => 'varchar',
            'logo' => 'varchar',
            'introduce' => 'varchar',
            'display_order' => 'int',
            'status' => 'int',
            'add_time' => 'int'
        );
    }

    public function getLinkListByCity($cityId){
        $linkList = $this->getAll('id,name,link,logo,introduce', array(
            array('status', '=', 1),
            array('city_id', '=', $cityId)
        ), array('display_order'=>'desc', 'id'=>'desc'));
        return $linkList;
    }
}
