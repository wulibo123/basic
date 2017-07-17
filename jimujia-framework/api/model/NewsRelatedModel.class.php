<?php
/**
 * 新闻关联
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      新闻关联
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class NewsRelatedModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_FORUM;
        $this->tableName      = 'pre_portal_article_related';
        $this->dbMasterConfig = DBConfig::$SERVER_FORUM;
        $this->dbSlaveConfig  = DBConfig::$SERVER_FORUM;
        $this->fieldTypes     = array(
            'aid' => 'mediumint',
            'raid' => 'mediumint',
            'displayorder' => 'mediumint'
        );
    }

    //获取相关联的文章的id列表
    function getRelatedArticleIdList($id){
        $idArr = $this->getAll('raid', array(
            array('aid', '=', $id)
        ), array('displayorder' => 'desc'));

        $idList = array('0');

        foreach($idArr as $id){
            $idList[] = $id['raid'];
        }

        return $idList;
    }
}
