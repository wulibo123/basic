<?php
/**
 * 房屋信息模型
 * @author    dubox
 * @since     2016.7.27
 * @desc
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguMemdailyModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_mem_daily';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'uid'=>'int',
            'title'=>'varchar',
            'cover_img'=>'varchar',
            'content'=>'text',
            'segment'=>'enum',
            'tags'=>'varchar',
            'add_time'=>'int',
            'status'=>'tinyint',

        );
    }

    //新增一条数据
    public function add($data) {

        if(!$data['add_time'])$data['add_time'] = time();
        $logId = $this->insert($data);
        return $logId;
    }

    //更新信息
    public function save($id, $data){
        return $this->update($data, array(
            array('id', '=', $id)
        ));
    }

    public function getAllByUid($uid){
        return $this->getAll('*', array(
                array('uid', '=', $uid),

            )
        );
    }

    public function getOneByUid($uid , $id){
        return $this->getRow('*', array(
                array('uid', '=', $uid),
                array('id', '=', $id),

            )
        );
    }

    public function getUidByid( $id){
        return $this->getOne('uid', array(
                array('id', '=', $id),

            )
        );
    }

    public function getNewByUid($uid ){
        return $this->getRow('*', array(
                array('uid', '=', $uid),
            )
            ,'add_time desc'
        );
    }

    /**
     * 每个用户最新日志列表
     * @param $p
     * @param int $num
     * @return FALSE表示执行失败
     */

    public function getFullList($p , $num = 10){

/*
        $count = $this->queryOne("select COUNT(1) as c
                from mg_mem_daily as D
                LEFT JOIN mg_member as M ON D.uid = M.id
                LEFT JOIN mg_mem_house as H ON D.uid = H.uid
                GROUP BY D.uid ORDER BY add_time DESC ");
*/
        $p = $p < 1 ?1:$p;
        $start = ($p-1)*$num;
        $sql = "select H.id,H.uid, max(D.id) as did,H.title,content ,H.cover_img,segment,add_time,area,`type`,style,budget,nickname,head_img,`view`
                from mg_mem_house as H
                LEFT JOIN mg_member as M ON H.uid = M.id
                LEFT JOIN mg_mem_daily as D ON D.uid = H.uid
                WHERE D.status = 1
                GROUP BY D.uid ORDER BY add_time DESC limit $start , $num";

        return $this->queryAll($sql);

    }

    /**
     * 获取日记中最新一条
     * @param $id
     * @return FALSE表示执行失败
     */

    public function getOneById($id){


        $sql = "select H.title,content
                from mg_mem_house as H
                LEFT JOIN mg_mem_daily as D ON D.uid = H.uid
                WHERE D.status = 1 AND H.id = $id
                 ORDER BY add_time DESC";

        return $this->queryRow($sql);

    }

    /**
     * 用户日志列表(装修日记详情)
     * @param $uid
     * @param $p
     * @param $is_my_daily 是否我的日记
     * @param int $num
     * @return FALSE表示执行失败
     */

    public function getListByUid($uid ,$p ,$is_my_daily = false, $num = 10){


        $p = $p < 1 ?1:$p;
        $start = ($p-1)*$num;

        $where_status = $is_my_daily ? '1' : 'status = 1';

        $sql = "select id,uid,content,segment,tags,status,add_time
                from mg_mem_daily
                 WHERE uid = $uid and $where_status
                 ORDER BY add_time asc ";//limit $start , $num

        return $this->queryAll($sql);

    }

    //删除图片
    public function del($data){
        return $this->delete( array(
            array('uid','=',$data['uid']),
            array('id','=',$data['id']),
        ));
    }




}
