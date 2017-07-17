<?php
/**
 * 新闻内容
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      新闻内容
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class NewsContentModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_FORUM;
        $this->tableName      = 'pre_portal_article_content';
        $this->dbMasterConfig = DBConfig::$SERVER_FORUM;
        $this->dbSlaveConfig  = DBConfig::$SERVER_FORUM;
        $this->fieldTypes     = array(
            'cid' => 'int',
            'aid' => 'mediumint',
            'id' => 'int',
            'idtype' => 'varchar',
            'title' => 'varchar',
            'content' => 'text',
            'pageorder' => 'smallint',
            'dateline' => 'int'
        );
    }

    function getNewsContentById($id){
        return $this->getOne('content', array(
            array('aid', '=', $id)
        ));
    }
}
