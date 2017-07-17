<?php
/**
 * 广告
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      广告
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class AdModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_ad';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'position_id' => 'int',
            'position_flag' => 'varchar',
            'city_id' => 'int',
            'title' => 'varchar',
            'photo' => 'varchar',
            'link' => 'varchar',
            'content' => 'varchar',
            'bg_color' => 'varchar',
            'status' => 'int',
            'display_order' => 'int'
        );
    }

    public function getAdListByFlag($cityId, $flag){
        $adList = $this->getAll('id,title,photo,link,content,bg_color', array(
            array('status', '=', 1),
            array('city_id', '=', $cityId),
            array('position_flag', '=', $flag)
        ), array('display_order'=>'desc', 'id'=>'desc'));
        return $adList;
    }
}
