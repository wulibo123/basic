<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class CategoryActivityModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'gb_category';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id'=>'mediumint',
            'category_type'=>'tinyint',
            'cagegory_name'=>'varchar',
            'display_order'=>'mediumint'
        );
    }

    //根据父ID获取所有子分类ID
    public function getCategoryInfoByParentId($parentId) {
        $where[] = is_array($parentId) ? array('parent_id', 'IN', $parentId) : array('parent_id', '=', $parentId);
        $row = $this->getAll('id,parent_id', $where);
       if(!empty($row)) {
            foreach($row as $key=>$val) {
                if(!empty($val['id'])) {
                    $ids[] = $val['id'];
                }
            }
            $this->getCategoryInfoByParentId($ids);
        }
        return $ids;
    }

    //根据ID获取分类信息
    public function getCategoryInfoById($id, $field = '*') {
        return $this->getRow($field, array(
            array('id', '=', $id)
        ));
    }

    //根据ID获取分类名称
    public function getCategoryNameById($id) {
        return $this->getOne('category_name', array(
            array('id', '=', $id)
        ));
    }
}
