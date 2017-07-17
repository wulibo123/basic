<?php
/**
 * 新闻分类
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      新闻分类
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class NewsCategoryModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_FORUM;
        $this->tableName      = 'pre_portal_category';
        $this->dbMasterConfig = DBConfig::$SERVER_FORUM;
        $this->dbSlaveConfig  = DBConfig::$SERVER_FORUM;
        $this->fieldTypes     = array(
            'catid' => 'int',
            'upid' => 'int',
            'catname' => 'varchar',
            'articles' => 'int',
            'allowcomment' => 'int',
            'displayorder' => 'int',
            'notinheritedarticle' => 'int',
            'notinheritedblock' => 'int',
            'domain' => 'varchar',
            'url' => 'varchar',
            'uid' => 'int',
            'username' => 'varchar',
            'dateline' => 'int',
            'closed' => 'int',
            'shownav' => 'int',
            'description' => 'text',
            'seotitle' => 'text',
            'keyword' => 'text',
            'primaltplname' => 'varchar',
            'articleprimaltplname' => 'varchar',
            'disallowpublish' => 'int',
            'foldername' => 'varchar',
            'notshowarticlesummay' => 'varchar',
            'perpage' => 'int',
            'maxpages' => 'int',
            'noantitheft' => 'int',
            'lastpublish' => 'int',
            'zx_flag' => 'int'
        );
    }

    public function getCategoryListByParantId($pid = 0){
        return $this->getAll('catid,upid,catname,articles,foldername,seotitle,keyword,description,zx_flag', array(
            array('upid', '=', $pid)
        ), array('displayorder' => 'desc'));
    }

    public function getCategoryInfoById($id){
        return $this->getRow('catid,upid,catname,articles,foldername,seotitle,keyword,description,zx_flag', array(
            array('catid', '=', $id)
        ));
    }

    public function getCategoryInfoByDir($dir){
        return $this->getRow('catid,upid,catname,articles,foldername,seotitle,keyword,description,zx_flag', array(
            array('foldername', '=', $dir)
        ));
    }

    public function getCategoryList(){
        return $this->getAll('catid,catname,foldername');
    }
}
