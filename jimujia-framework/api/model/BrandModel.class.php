<?php
/**
 * 品牌模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class BrandModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_brand';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'brand_name' => 'varchar',
            'introduce' => 'varchar',
            'logo' => 'varchar',
            'banner' => 'varchar',
            'album' => 'varchar',
            'status' => 'int',
            'display_order' => 'int'
        );
    }

    function getBrandInfoById($id){
        return $this->getRow('*', array(
            array('id', '=', $id),
            array('status', '=', 1)
        ));
    }

    public function getBrandListByIds($ids, $field = 'id,brand_name,logo'){
        return $this->getAll($field, array(
            array('id', 'in', explode(',', $ids))
        ));
    }
}
