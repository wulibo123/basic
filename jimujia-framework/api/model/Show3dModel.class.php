<?php
/**
 * 房屋信息模型
 * @author    dubox
 * @since     2016.7.27
 * @desc
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class Show3dModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_3dshow';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'city'=>'varchar',
            'shi'=>'tinyint',
            'area'=>'int',
            'name'=>'varchar',
            'cover_img_pc'=>'varchar',
            'cover_img_mobile'=>'varchar',
            'url'=>'varchar',
            'addtime'=>'int',
        );
    }




}
