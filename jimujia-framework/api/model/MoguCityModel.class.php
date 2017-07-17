<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguCityModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_city';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'domain'=>'varchar',
            'code'=>'varchar',
            'name'=>'varchar',
            'provincecode'=>'varchar',
            'is_using'=>'tinyint',
        );
    }

    //根据domain获取城市信息
    public function getCityInfoByDomain($domain, $fields = '*') {
        return $this->getRow($fields, array(
            array('domain', '=', $domain),
            array('is_using', '=', 1)
        ));
    }

    //获取所有城市
    public function getCityList($fields='*') {
        return $this->getAll($fields, array(
            array('is_using', '=', 1)
        ),array('sort'=>'asc'));
    }
}
