<?php
/**
 * 主材包包含的品牌
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      主材包包含的品牌
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class BrandPackModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_brand_pack';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'brand_id' => 'int',
            'pack_id' => 'int'
        );
    }

    public function getBrandIdsByPackId($packId){
        return $this->getOne('group_concat(brand_id) as brand_ids', array(
            array('pack_id', '=', $packId)
        ));
    }
}
