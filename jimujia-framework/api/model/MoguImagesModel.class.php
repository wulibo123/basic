<?php
/**
 * 房屋信息模型
 * @author    dubox
 * @since     2016.7.27
 * @desc
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguImagesModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_images';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'uid'=>'int',
            'ext_name'=>'varchar',
            'ext_id'=>'int',
            'img'=>'varchar',
            'description'=>'text',
            'add_time'=>'int',
            'status'=>'tinyint',

        );
    }

    //新增一条数据
    public function add($data) {

        $data['add_time'] = time();
        if(!$data['description'])$data['description'] = '';
        $logId = $this->insert($data);
        return $logId;
    }

    //更新信息
    public function save($id, $data){
        return $this->update($data, array(
            array('id', '=', $id)
        ));
    }

    //删除图片
    public function del($data){
        return $this->delete( array(
            array('uid','=',$data['uid']),
            array('img','=',$data['img']),
        ));
    }

    public function getByExt($e_name , $e_id){
        $res = $this->getAll('img,description', array(
                array('ext_id', '=', $e_id),
                array('ext_name', '=', $e_name),

            )
        );

        if(!$res)return [];

        foreach($res as $k=>$v){
            $res[$k]['img_id'] = $v['img'];
            $res[$k]['img'] = 'http://' . SystemConfig::MOGU_APP_DOMAIN_IMG . '/'.$v['img'];
        }
        return $res;
    }


}
