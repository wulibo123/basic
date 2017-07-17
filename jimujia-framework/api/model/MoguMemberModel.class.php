<?php
/**
 * 预约模型
 * @author    初九 <527891885@qq.com>
 * @since     2014-8-22
 * @desc      品牌对应活动模型
 */

require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';
class MoguMemberModel extends BaseModel {

    protected function init() {
        $this->dbName         = DBConfig::DB_MARIO;
        $this->tableName      = 'mg_member';
        $this->dbMasterConfig = DBConfig::$SERVER_MASTER_MARIO;
        $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE_MARIO;
        $this->fieldTypes     = array(
            'id'=>'int',
            'name'=>'varchar',
            'phone'=>'varchar',
            'nickname'=>'varchar',
            'email'=>'varchar',
            'head_img'=>'varchar',
            'city'=>'varchar',
            'source'=>'varchar',
            'openid'=>'varchar',
            'reg_time'=>'int',
            'login_time'=>'int',
            'customer_id'=>'int',
            'customer_no'=>'varchar',
            'platform'=>'varchar',
            'device_token'=>'varchar',
            'status'=>'tinyint',

        );
    }

    //新增一条数据
    public function add($data) {
        if(empty($data['phone'])){
            return false;
        }
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

    public function getUserById($id){
        return $this->getRow('nickname,head_img', array(
            array('id', '=', $id),

            )
        );
    }

    public function getUserByPhone($phone){
        return $this->getRow('*', array(
            array('phone', '=', $phone),

            )
        );
    }

    public function getUserByOpenid($openid){
        return $this->getRow('*', array(
                array('openid', '=', $openid),

            )
        );
    }


}
