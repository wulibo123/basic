<?php
/**
 * 分类模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      分类模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class CategoryModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'tz_category';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id' => 'int',
            'parent_id' => 'int',
            'category_name' => 'varchar',
            'description' => 'varchar',
            'status' => 'int',
            'display_order' => 'int'
        );
    }

    public function getCategoryList(){
        $categoryList = $this->getAll('*',
            array(array('status', '=', 1)),
            array('display_order'=>'desc')
        );
        return $categoryList;
    }
}
