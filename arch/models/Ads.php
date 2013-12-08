<?php
/**
 * Data model for advertisements
 * @author songrenchu, Xiangyan Sun
 */
class Ads extends RModel {
    public $publisher;
    public $id, $userId, $pubTime, $title, $content, $status, $paidPrice;

    const APPLYING = 1;
    const BLOCKED = 2;
    // Approved ads can show on some pages of the site
    const APPROVED = 3;
    const REMOVED = 4;

    const ENTITY_ID = 3;

    public static $primary_key = 'id';
    public static $table = 'ads';
    public static $mapping = array(
        'id'=>'ads_id',
        'userId'=>'ads_user_id',
        'pubTime'=>'ads_pub_time',
        'title'=>'ads_title',
        'content'=>'ads_content',
        'status'=>'ads_status',
        'paidPrice'=>'ads_paid_price',
    );

    public function load($id=null)
    {
        $result = parent::load($id);
        if($result==null) return null;
        $this->publisher = new User();
        $this->publisher->id = $this->userId;
        $this->publisher->load();

        return $this;
    }

    public function apply($userId,$title,$content,$paidPrice,$applyTime = null){
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
        $this->paidPrice = $paidPrice;
        $this->pubTime = $applyTime!=null? $applyTime : date('Y-m-d H:i:s');
        $this->status = self::APPLYING;
        $id = $this->insert();
        if(is_numeric($id)){
            $this->load($id);
            return true;
        }
        else{
            return false;
        }
    }

    public function block($adId=''){
        $this->markStatus($adId,self::BLOCKED);
    }


    public function activate($adId=''){
        $this->markStatus($adId,self::APPROVED);
    }

    private function markStatus($adId, $status)
    {
        if (isset($adId) && is_numeric($adId)) {
            $this->id = $adId;
        }
        if(isset($this->id) && is_numeric($this->id)){
            $this->load();
            $this->status = $status;
            $this->update();
        }
    }

    public function getUserAds($userId, $type) {
        if(!isset($userId)||$userId==''){
            return null;
        }
        $ads = new Ads();
        $ads->userId = $userId;
        $ads->status = $type;
        /* TODO pager */
        return $ads->find(0, 0, ['key' => 'ads_id', 'order' => 'desc']);
    }

    public static function getPublishedAds() {     //get published advertisements, order by paid price, but the effectiveness of price deminish along with the elapse of timer
        return self::find()->order("desc", self::$mapping['pubTime'] . " / 10000 + " . self::$mapping['paidPrice'])->all();
    }

    public function delete() {
        $this->markStatus($this->id, Ads::REMOVED);
    }
}