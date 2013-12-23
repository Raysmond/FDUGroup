<?php
/**
 * RatingLike data model
 *
 * @author: Raysmond
 */

// TODO replace RatingPlus class with RatingLike model

class RatingLike extends Rating{

    public $tag = "like";
    public $value = 1;
    public $valueType = "integer";

    const TAG = "like";
    const VALUE = 1;
    const VALUE_TYPE = "integer";

    public function save(){
        if(!isset($this->timestamp)||$this->timestamp==''){
            $this->timestamp = date('Y-m-d H:i:s');
        }
        return parent::save();
    }

    public static function like($entityId, $entityType,$userId,$host){
        $like = RatingLike::find(["entityId",$entityId,"entityType",$entityType,'tag',self::TAG,"valueType",self::VALUE_TYPE])->first();
        if($like==null){
            $like = new RatingLike();
            $like->userId = $userId;
            $like->host = $host;
            $like->entityId = $entityId;
            $like->entityType = $entityType;
            $like->timestamp = date('Y-m-d H:i:s');
            $like->save();

            // todo increase total like count

            if($like->id)
                return $like;
        }
        return false;
    }

    public static function unlike($userId,$entityId,$entityType){
        $like = RatingLike::find(["entityId",$entityId,"entityType",$entityType,'tag',self::TAG,"valueType",self::VALUE_TYPE])->first();
        if($like!=null){
            $like->delete();

            // todo decrease total like count
            return true;
        }
        return false;
    }

    public static function getUserLikePosts($userId,$start = 0, $limit = 0){
        $likes = RatingLike::find(["entityType",Topic::ENTITY_TYPE,"userId",$userId])->all();

        $query = Topic::find()->order_desc("id");
        if(!empty($likes)){
            $args = [];
            $where = "[id] in (";
            for($i=0,$count = count($likes);$i<$count;$i++){
                $args[] = $likes[$i]->entityId;
                $where.='?'.($i<$count-1)?",":"";
            }
            unset($likes);
            $where.=")";
            $query = $query->where($where,$args);
        }

        if($start!=0||$limit!=0)
            return $query->range($start,$limit);
        else
            return $query->all();
    }

    public static function getUsrLikeGroups($userId, $start = 0, $limit = 0){
        $likes = RatingLike::find(["entityType",Group::ENTITY_TYPE,"userId",$userId])->all();

        $query = Group::find()->order_desc("id");
        if(!empty($likes)){
            $args = [];
            $where = "[id] in (";
            for($i=0,$count = count($likes);$i<$count;$i++){
                $args[] = $likes[$i]->entityId;
                $where.='?'.($i<$count-1)?",":"";
            }
            unset($likes);
            $where.=")";
            $query = $query->where($where,$args);
        }

        if($start!=0||$limit!=0)
            return $query->range($start,$limit);
        else
            return $query->all();
    }
} 