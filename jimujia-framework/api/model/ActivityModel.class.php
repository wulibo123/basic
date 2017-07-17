<?php
/**
 * 品牌对应活动模型
 * @author    高世考 <gaoshikao@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class ActivityModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_WEB;
        $this->tableName      = 'gb_activity_new';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
        $this->fieldTypes     = array(
            'id'=>'int',
            'domain'=>'varchar',
            'activity_name'=>'varchar',
            'category_id'=>'mediumint',
            'category_id2'=>'mediumint',
            'category_id3'=>'mediumint',
            'banner_bgcolor'=>'char',
            'body_bgcolor'=>'char',
            'summary_bgcolor'=>'char',
            'input_bgcolor'=>'char',
            'input_bottomcolor'=>'char',
            'trilateral_color'=>'char',
            'is_left_enabled'=>'tinyint',
            'bottom_input_bgcolor'=>'char',
            'photo'=>'varchar',
            'left_photo'=>'varchar',
            'left_photo_link'=>'varchar',
            'init_number'=>'smallint',
            'reason1'=>'varchar',
            'reason1_link'=>'varchar',
            'reason2'=>'varchar',
            'reason2_link'=>'varchar',
            'reason3'=>'varchar',
            'reason3_link'=>'varchar',
            'arrival_msg'=>'varchar',
            'wecaht_tick'=>'varchar',
            'apply_msg'=>'varchar',
            'starting_time'=>'int',
            'address'=>'varchar',
            'arrival_way'=>'varchar',
            'map_longitude'=>'varchar',
            'map_latitude'=>'varchar',
            'display_order'=>'int',
            'status'=>'tinyint',
            'is_recommend'=>'tinyint',
            'mobile_msg'=>'varchar',
            'start_time'=>'int',
            'end_time'=>'int',
            'add_time'=>'int',
            'mobile_photo'=>'varchar',
            'number'=>'mediumint',
            'is_deleted'=>'tinyint',
        );
    }

    //获取推荐活动
    public function getRecommendActivityList($field = '*', $cityDomain = '', $limit = 10) {
        return $this->getAll($field, array(
            array('status','=',1),
            array('is_recommend','=',1),
            array('domain', '=', $cityDomain),
        ), array('display_order'=>'desc'), 0, $limit);
    }

    //根据id获取活动信息
    public function getActivityInfoById($id, $field = '*') {
        return $this->getRow($field, array(
            array('status','=',1),
            array('id','=',$id),
            array('domain', '=', DomainUtil::getDomain()),
        ));
    }

    //根据分类分类id获取活动信息
    public function getActivityInfoByCategoryId($id, $field = '*') {
        return $this->getAll($field, array(
            array('domain', '=', DomainUtil::getDomain()),
            array('category_id', '=', $id),
            array('status','=',1)
        ), array('display_order'=>'desc'));
    }

    // 获取所有活动
    public function getActivityList($field = '*') {
        return $this->getAll($field, array(
            array('domain', '=', DomainUtil::getDomain()),
            array('status','=',1)
        ), array('display_order'=>'desc'));
    }

    //根据ids获取活动列表
    public function getActivityListByIds($ids, $field = '*') {
        return $this->getAll($field, array(
            array('id', 'in', (array)$ids),
            array('domain', '=', DomainUtil::getDomain()),
            array('status','=',1)
        ), array('display_order'=>'desc'));
    }

    //根据获取一个字段的值
    public function getFieldValue($id, $field = 'arrival_msg') {
        return $this->getOne($field, array(
            array('id', '=', $id),
            array('status','=',1)
        ));
    }
}
