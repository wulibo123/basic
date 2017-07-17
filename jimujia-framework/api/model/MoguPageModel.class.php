<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      蘑菇页面设置模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguPageModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_page';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'domain'=>'varchar',
            'type'=>'enum',
            'name'=>'varchar',
            'value'=>'text',
            'add_time'=>'int',
        );
    }

    //根据domain 和页面名称获取页面信息 pc
    public function getPageInfoByDomain($domain, $name = '', $fields = 'name,value') {
        if(!$domain || !$name) return fasle;
        return $this->getRow($fields, array(
            array('domain', '=', $domain),
            array('name', '=', $name),
            array('type', '=', 'pc')
        ));
    }

    //pages pc
    public function getPagesByDomain($domain, $name = '', $fields = 'name,value') {
        if(!$domain || !$name) return fasle;
        return $this->getAll($fields, array(
            array('domain', '=', $domain),
            array('name', 'in', $name),
            array('type', '=', 'pc')
        ));
    }

    //根据domain 和页面名称获取页面信息 mobile
    public function getPageInfoByDomainMobile($domain, $name = '', $fields = 'name,value') {
        if(!$domain || !$name) return fasle;
        return $this->getRow($fields, array(
            array('domain', '=', $domain),
            array('name', '=', $name),
            array('type', '=', 'mobile')
        ));
    }

    //根据domain 和页面名称获取页面信息 mobile
    public function getPagesByDomainMobile($domain, $name = '', $fields = 'name,value') {
        if(!$domain || !$name) return fasle;
        return $this->getAll($fields, array(
            array('domain', '=', $domain),
            array('name', 'in', $name),
            array('type', '=', 'mobile')
        ));
    }

    //获取商城设置信息
    public function getShopInfoByPage($name, $fields = 'value') {
        if(!$name) return fasle;
        return $this->getOne($fields, array(
            array('name', '=', $name),
            array('type', '=', 'shop')
        ));
    }
    //获取用户效果图设置信息
    public function getDrawingByPage($name,$fields = "value"){
    	if(!$name) return fasle;
    	return $this->getOne($fields, array(
    			array('name', '=', $name),
    			array('type', '=', 'drawing')
    	));
    }

}
