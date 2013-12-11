<?php
/**
 * Data model for advertisements
 *
 * @author songrenchu, Xiangyan Sun, Raysmond
 */
class Ads extends RModel {
    public $publisher;
    public $id, $userId, $pubTime, $title, $content, $status, $paidPrice;

    const APPLYING = 1;
    const BLOCKED = 2;
    const APPROVED = 3;
    const REMOVED = 4;

    const ENTITY_TYPE = 3;

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
        'publisher' => array('User', '[userId] = [User.id]')
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

    //get published advertisements, order by paid price, but the effectiveness of price deminish along with the elapse of timer
    public static function getPublishedAds() {
        return self::find(["status",static::APPROVED])->order("desc", "[pubTime] / 10000 + [paidPrice]")->all();
    }

    public function delete() {
        $this->status = static::REMOVED;
        $this->save();
    }
}