<?php
/**
 * 分站
 * @author    dubox
 * @since     2017.6.8
 * @desc
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguSiteModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_site';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'level'=>'tinyint',
            'region_id'=>'int',
            'code'=>'int',
            'name'=>'varchar',
            'domain'=>'varchar',
            'status'=>'tinyint',
            'keywords'=>'varchar',
            'sort'=>'tinyint',
            'addtime'=>'int',
        );
    }

    //根据domain获取城市信息
    public function getSiteByDomain($domain, $fields = '*') {
        return $this->getRow($fields, array(
            array('domain', '=', $domain)
        ));
    }

    //获取所有城市
    public function getList($fields='*') {
        return $this->getAll($fields, array(
            array('status', '=', 1)
        ),array('sort'=>'asc'));
    }
}
