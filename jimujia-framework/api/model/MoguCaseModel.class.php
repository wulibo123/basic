<?php
/**
 * 装修案例模型
 * @author    dubox
 * @since     2016.7.27
 * @desc
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguCaseModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_case';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'admin_id'=>'int',
            'nickname'=>'varchar',
            'title'=>'varchar',
            'head_img'=>'varchar',
            'cover_img'=>'varchar',
            'type_img'=>'varchar',
            'area'=>'decimal',
            'house_type'=>'varchar',
            'style'=>'varchar',
            'url'=>'varchar',
            'view'=>'int',
            'favorite'=>'int',
            'add_time'=>'int',
            'status'=>'tinyint',

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


    public function getOneById( $id){
        return $this->getRow('id,nickname,title,head_img,cover_img,type_img,area,house_type,url,style,view,favorite,add_time', array(
                array('id', '=', $id),
                array('status', '=', 1),

            )
        );
    }


    /**
     * 列表
     * @param $p
     * @param int $num
     * @return FALSE表示执行失败
     */

    public function getList($p , $num = 10){


        $p = $p < 1 ?1:$p;
        $start = ($p-1)*$num;
        $sql = "select id,nickname,head_img,title,area,house_type,cover_img,style,`view`,favorite,add_time
                from mg_case

                 ORDER BY add_time DESC limit $start , $num";

        return $this->queryAll($sql);

    }


    //增加收藏数
    public function addFav($id){

        return $this->execute("update mg_case set favorite = favorite+1 WHERE id=$id");
    }

    //增加浏览数
    public function addView($id){

        return $this->execute("update mg_case set `view` = `view`+1 WHERE id=$id");
    }

}
