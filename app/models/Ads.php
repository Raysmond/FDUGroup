<?php
/**
 * Data model for advertisements
 *
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

    public static $relation = array(
        'publisher'=>array('userId','User','id')
    );

    public function apply($userId,$title,$content,$paidPrice,$applyTime = null){
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
        $this->paidPrice = $paidPrice;
        $this->pubTime = $applyTime!=null? $applyTime : date('Y-m-d H:i:s');
        $this->status = self::APPLYING;
        $this->save();
        return isset($this->id);
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
        return self::find()->order("desc", "[pubTime] / 10000 + [paidPrice]")->all();
    }

    public function delete() {
        $this->markStatus($this->id, Ads::REMOVED);
    }
}