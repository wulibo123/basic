<?php
/**
 * 房屋信息模型
 * @author    dubox
 * @since     2016.7.27
 * @desc
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguMemhouseModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_mem_house';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'uid'=>'int',
            'province'=>'varchar',
            'city'=>'varchar',
            'community'=>'varchar',
            'area'=>'decimal',
            'type'=>'varchar',
            'style'=>'varchar',
            'budget'=>'decimal',
            'title'=>'varchar',
            'cover_img'=>'varchar',
            'view'=>'int',
            'favorite'=>'int',

        );
    }

    //新增一条数据
    public function add($data) {

        $data['add_time'] = time();
        $logId = $this->insert($data);
        return $logId;
    }

    //更新信息
    public function save($id, $data){
        return $this->update($data, array(
            array('id', '=', $id)
        ));
    }

    public function getByUid($uid){
        return $this->getRow('*', array(
                array('uid', '=', $uid),

            )
        );
    }

    public function getById($id){
        return $this->getRow('*', array(
                array('id', '=', $id),

            )
        );
    }

    //增加收藏数
    public function addFavById($id){

        return $this->execute("update mg_mem_house set favorite = favorite+1 WHERE id=$id");
    }

    //增加收藏数
    public function addFavByUid($uid){

        return $this->execute("update mg_mem_house set favorite = favorite+1 WHERE uid=$uid");
    }

    //增加浏览数
    public function addView($id){

        return $this->execute("update mg_mem_house set `view` = `view`+1 WHERE id=$id");
    }


}
