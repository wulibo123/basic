<?php
/**
 * Created by PhpStorm.
 * User: vvtommy
 * Date: 15/5/13
 * Time: 下午3:39
 */
require_once FRAMEWORK_PATH . '/util/db/BaseModel.class.php';
require_once CONF_PATH . '/db/DBConfig.class.php';

require_once FRAMEWORK_PATH . '/util/lane_wechat/lanewechat.php';

use LaneWeChat\Core\Popularize;

class ProductQrException extends Exception {}

class MGMallProductQrModel extends BaseModel {

//  scene id 从 80000 开始
  const SCENE_ID_START=8e4;
//  scene id 最长9999
  const SCENE_ID_MAX=9999;

  protected function init() {
    $this->dbName         = DBConfig::DB_MARIO;
    $this->tableName      = 'mg_mall_product_qr';
    $this->dbMasterConfig = DBConfig::$SERVER_MASTER;
    $this->dbSlaveConfig  = DBConfig::$SERVER_SLAVE;
    $this->fieldTypes     = array(
      'id'=>'int',
      'product_id'=>'varchar',
      'scene_id'=>'int',
      'created_time'=>'datetime',
      'image_data'=>'blob',
    );
  }

  public function getQrById($productId){
//    首先查询数据库中是否已经存在，如果已经存在就直接返回
    if($resultQr=$this->getOne('image_data',[
      ['product_id','=',$productId]
    ])){
      return $resultQr;
    }

//    重新获取
    return $this->getNewQrCodeById($productId);
  }

  public function getNewQrCodeById($productId){
    if(false===$resultCount=$this->getOne('count(`id`)')){
      throw new ProductQrException('Count Qr Code in database failed.');
      return false;
    }
    if(self::SCENE_ID_START+self::SCENE_ID_MAX<$sceneId=self::SCENE_ID_START+$resultCount){
      throw new ProductQrException('Scene id max reached.');
      return false;
    }
    if(!$ticket=Popularize::createTicket(2, null, $sceneId)){
      throw new ProductQrException('Get Qr code ticket failed');
      return false;
    }
    if(!$image=Popularize::getQrcode($ticket['ticket'])){
      throw new ProductQrException('Get Qr code image failed');
      return false;
    }
    if(!$this->insert([
      'product_id'=>$productId,
      'image_data'=>$image,
      'scene_id'=>$sceneId,
    ])){
      throw new ProductQrException('Save new qr code failed.');
      return false;
    }
    return $image;
  }

  //新增一条记录
  public function createLog($data) {
    if(empty($data['mobile']) || empty($data['activity_id']) || empty($data['voting_id'])){
      return false;
    }
    $data['add_time'] = time();
    $logId = $this->insert($data);
    return $logId;
  }

}

