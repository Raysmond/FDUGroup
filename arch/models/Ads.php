<?php
/**
 * Created by PhpStorm.
 * User: songrenchu
 */
class Ads extends Data{
    public $publisher;
    public $id,$userId,$pubTime,$title,$content,$status,$paidPrice;

    public static $NORMAL = 1;
    public static $REMOVED = 2;

    public function __construct()
    {
        $options = array(
            'key'=>'id',
            'table'=>'ads',
            'columns'=>array(
                'id'=>'ads_id',
                'userId'=>'ads_user_id',
                'pubTime'=>'ads_pub_time',
                'title'=>'ads_title',
                'content'=>'ads_content',
                'status'=>'ads_status',
                'paidPrice'=>'ads_paid_price',
            )
        );
        parent::init($options);
    }

    public function load($id=null)
    {
        $result = parent::load($id);
        if($result==null) return null;
        $this->publisher = new User();
        $this->publisher->id = $this->userId;
        $this->publisher->load();

        return $this;
    }

    public function block($adId=''){
        $this->markStatus($adId,self::$REMOVED);
    }

    public function activate($adId=''){
        $this->markStatus($adId,self::$NORMAL);
    }

    public function markStatus($adId, $status)
    {
        if (isset($adId) && is_numeric($adId)) {
            $this->id = $adId;
            $result = $this->load();
            if ($result != null) {
                $this->status = $status;
                $this->update();
            }
        }
    }
}