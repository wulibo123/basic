<?php
/**
 * 品牌对应商家模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应商家模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class BrandMerchantModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_brand_merchant';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'brand_id' => 'int',
            'merchant_id' => 'int'
        );
    }

    public function getMerchantIdByBrandId($brandId) {
        return $this->getOne('group_concat(merchant_id)',array(
            array('brand_id'=>$brandId)
        ));
    }
}
