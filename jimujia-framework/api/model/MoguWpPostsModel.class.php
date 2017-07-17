<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguWpPostsModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MOGU_WP;
        $this->tableName      = 'wp_posts';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_WP_MASTER_MARIO;
        $this->fieldTypes     = array(
            'ID'=>'bigint',
            'post_author'=>'bigint',
            'post_date'=>'datetime',
            'post_date_gmt'=>'datetime',
            'post_content'=>'longtext',
            'post_title'=>'text',
            'post_excerpt'=>'text',
            'post_status'=>'varchar',
            'comment_status'=>'varchar',
            'ping_status'=>'varchar',
            'post_password'=>'varchar',
            'post_name'=>'varchar',
            'to_ping'=>'text',
            'pinged'=>'text',
            'post_modified' => 'datetime',
            'post_modified_gmt' => 'datetime',
            'post_content_filtered' => 'longtext',
            'post_parent' => 'bigint',
            'guid' => 'varchar',
            'menu_order' => 'int',
            'post_type' => 'varchar',
            'post_mime_type' => 'varchar',
            'comment_count' => 'bigint'
        );
    }

    //根据订单号查询订单状态
    public function getArticleListByCategoryId($catid, $fields = '*', $limit='4') {
        $sql = 'SELECT '.$fields.' FROM wp_posts WHERE ID IN (SELECT object_id FROM wp_term_relationships WHERE term_taxonomy_id='.$catid.') ORDER BY post_modified DESC LIMIT 0,'.$limit;
        return $this->queryAll($sql);
    }
}
