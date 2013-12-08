<?php
/**
 * Wallet data model class
 * @author: Raysmond
 * @date: 13-11-24
 */

class Wallet extends Data{
    public $user;

    const COIN_NAME = 'Group Coins';

    public $userId,$type,$money,$frozenMoney,$timestamp;

    public function __construct(){
        $option = array(
            "key" => "userId",
            "table" => "wallet",
            "columns" => array(
                'userId'=>'u_id',
                "type" => "w_type",
                "money" => "w_money",
                "frozenMoney" => "w_frozen_money",
                "timestamp" => "w_timestamp"
            ),

        );
        parent::init($option);
    }

    public function load($userId=null){
        $result = parent::load($userId);
        if($result==null) return null;
        $this->user = new User();
        $this->user->id = $this->userId;
        return $this;
    }

    public function addMoney($money){
        if(!isset($money)||!is_numeric($money)){
            return fasle;
        }
        else{
            return $this->updateMoney($this->money + $money);
        }
    }

    public function cutMoney($money){
        if(!isset($money)||!is_numeric($money)){
            return fasle;
        }
        else{
            return $this->updateMoney($this->money - $money);
        }
    }

    public function frozenMoney($money){
        if(!isset($money)||!is_numeric($money)){
            return fasle;
        }
        else{
            if($this->isSetUserId()){
                $this->frozenMoney = $money;
                $this->update();
                return true;
            }
        }
    }

    private function updateMoney($money){
        if($this->isSetUserId()){
            $this->money = $money;
            $this->timestamp = date('Y-m-d H:i:s');
            $this->update();
            return true;
        }
        else return false;
    }

    private function isSetUserId(){
        return isset($this->userId)&&is_numeric($this->userId);
    }
} 