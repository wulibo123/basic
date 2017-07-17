<?php
/**
 * 新闻主体
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      新闻主体
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class NewsModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_FORUM;
        $this->tableName      = 'pre_portal_article_title';
        $this->dbMasterConfig = DBConfig::$SERVER_FORUM;
        $this->dbSlaveConfig  = DBConfig::$SERVER_FORUM;
        $this->fieldTypes     = array(
            'aid' => 'int',
            'catid' => 'mediumint',
            'bid' => 'int',
            'uid' => 'varchar',
            'username' => 'varchar',
            'title' => 'text',
            'highlight' => 'smallint',
            'author' => 'int',
            'from' => 'int',
            'fromurl' => 'int',
            'url' => 'int',
            'summary' => 'int',
            'pic' => 'int',
            'thumb' => 'int',
            'remote' => 'int',
            'id' => 'int',
            'idtype' => 'int',
            'contents' => 'int',
            'allowcomment' => 'int',
            'owncomment' => 'int',
            'click1' => 'int',
            'click2' => 'int',
            'click3' => 'int',
            'click4' => 'int',
            'click5' => 'int',
            'click6' => 'int',
            'click7' => 'int',
            'click8' => 'int',
            'tag' => 'int',
            'dateline' => 'int',
            'status' => 'int',
            'showinnernav' => 'int',
            'preaid' => 'int',
            'nextaid' => 'int',
            'htmlmade' => 'int',
            'htmlname' => 'varchar',
            'htmldir' => 'int'
        );
    }

    //根据分类id列表获取文章列表
    public function getNewsListByCategoryIds($idArr = array(), $offset = 0, $limit = 15){
        return $this->getAll('aid,catid,htmlname,dateline,title,pic', array(
            array('catid', 'in', $idArr)
        ), array('dateline' => 'desc'), $offset, $limit);
    }

    public function getNewsInfoByName($name){
        return $this->getRow('aid,catid,htmlname,dateline,title,pic,author,`from`,summary,preaid,nextaid,url', array(
            array('htmlname', '=', $name)
        ));
    }

    public function getNewsInfoById($id){
        return $this->getRow('aid,catid,htmlname,dateline,title,pic,author,`from`,summary,preaid,nextaid,url', array(
            array('aid', '=', $id)
        ));
    }

    //根据id列表获取文章列表
    public function getNewsListByIdArr($idArr){
        return $this->getAll('aid,catid,htmlname,dateline,title,pic', array(
            array('aid', 'in', $idArr)
        ), array('dateline' => 'desc'));
    }

    //获取热点新闻
    public function getNewslistByTag($tag = 2){
        return $this->queryAll("select aid,catid,htmlname,dateline,title,pic from ".$this->dbName.'.'.$this->tableName.
            " where (tag & '2' = '2') order by dateline desc limit 15"
        );
    }

    //获取所有文章，仅在sitemap中使用
    public function getNewsList(){
        return $this->getAll('aid,catid,htmlname,dateline', array(
            array('aid', 'in', $idArr)
        ), array('dateline' => 'desc'));
    }

    function article_make_tag($tags) {
        $tags = (array)$tags;
        $tag = 0;
        for($i=1; $i<=8; $i++) {
            if(!empty($tags[$i])) {
                $tag += pow(2, $i-1);
            }
        }
        return $tag;
    }
}
