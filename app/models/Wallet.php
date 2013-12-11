<?php
/**
 * Wallet data model class
 *
 * @author: Raysmond
 */

class Wallet extends RModel{
    public $user;

    const COIN_NAME = 'Group Coins';

    public $userId,$type,$money,$frozenMoney,$timestamp;

    public static $table = "wallet";
    public static $primary_key = "userId";

    public static $mapping = array(
        'userId'=>'u_id',
        "type" => "w_type",
        "money" => "w_money",
        "frozenMoney" => "w_frozen_money",
        "timestamp" => "w_timestamp"
    );

    public static $relation = array(
        'user' => array("User", "[userId] = [User.id]")
    );



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
                $this->save();
                return true;
            }
        }
    }

    private function updateMoney($money){
        if($this->isSetUserId()){
            $this->money = $money;
            $this->timestamp = date('Y-m-d H:i:s');
            $this->save();
            return true;
        }
        else return false;
    }

    private function isSetUserId(){
        return isset($this->userId)&&is_numeric($this->userId);
    }
} 