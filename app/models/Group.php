<?php
/**
 * Group data model
 * @author: Raysmond, Xiangyan Sun
 */

class Group extends RModel
{
    public $groupCreator;
    public $category;
    public $id, $creator, $categoryId, $name, $memberCount, $createdTime, $intro, $picture;

    const ENTITY_TYPE = 2;
    const PICTURE_PATH = '/files/images/groups/';

    public static $labels = array(
        "id" => "ID",
        "creator" => "Creator",
        "categoryId" => "Category",
        "name" => "Name",
        "memberCount" => "Member count",
        "createdTime" => "Create time",
        "intro" => "Introduction",
        "picture" => 'Picture'
    );

    public static $defaults = array('picture' => 'public/images/default_pic.png');

    public static $primary_key = "id";
    public static $table = "groups";
    public static $mapping = array(
        "id" => "gro_id",
        "creator" => "gro_creator",
        "categoryId" => "cat_id",
        "name" => "gro_name",
        "memberCount" => "gro_member_count",
        "createdTime" => "gro_created_time",
        "intro" => "gro_intro",
        "picture" => 'gro_picture'
    );
    public static $relation = array(
        "groupCreator" => array("creator", "User", "id"),
        "category" => array("categoryId", "Category", "id")
    );

    public static function countTopics($groupId)
    {
        return Topic::find("groupId", $groupId)->count();
    }

    public static function getGroupsOfCategory($categoryId, $start = 0, $limit = 0, $withSubCategory = true)
    {
        $category = Category::get($categoryId);
        if ($category == null) {
            return array();
        }

        $query = Group::find();
        $whereIds = Group::$mapping["categoryId"] . " in(";
        if ($withSubCategory) {
            $subs = $category->children();
            $count = count($subs);
            $i = 0;
            foreach ($subs as $sCat) {
                $cidList[] = $sCat->id;
                $whereIds .= $sCat->id;
                if (++$i < $count) $whereIds .= ',';
            }
            $whereIds .= ')';
            unset($subs);
        }

        $query = $query->where($whereIds);
        $groups = ($start != 0 || $limit != 0) ? $query->range($start, $limit) : $query->all();
        return $groups;
    }

    public static function getMembers($groupId, $start = 0, $limit = 0, $orderBy = "", $order = 'DESC')
    {
        $query = GroupUser::find("groupId", $groupId);
        if ($orderBy != "") {
            $query = ($order == "ASC" || $order == "asc") ? $query->order_asc($orderBy) : $query->order_desc($orderBy);
        }

        $groupUsers = ($start != 0 || $limit != 0) ? $query->range($start, $limit) : $query->all();

        // todo get all members at a time
        $users = [];
        foreach ($groupUsers as $item) {
            $users[] = User::get($item->userId);
        }
        unset($groupUsers);

        return $users;
    }

    public function setDefaults()
    {
        if (!isset($this->memberCount))
            $this->memberCount = 1;
        $this->createdTime = date('Y-m-d H:i:s');
    }

    public function buildGroup($groupName, $categoryId, $introduction, $creatorId, $picture = '')
    {
        $group = new Group();
        $group->setDefaults();
        $group->name = $groupName;
        $group->categoryId = $categoryId;
        $group->intro = $introduction;
        $group->creator = $creatorId;
        $group->picture = $picture;
        $group->save();

        $groupUser = new GroupUser();
        $groupUser->groupId = $group->id;
        $groupUser->userId = $group->creator;
        $groupUser->joinTime = date('Y-m-d H:i:s');
        $groupUser->status = 1;
        $groupUser->save();

        return $group;
    }

    public function uploadPicture($fileTag)
    {
        $uploadPath = Rays::app()->getBaseDir() . '/../' . self::PICTURE_PATH;
        $picName = 'group_' . $this->id . RUploadHelper::get_extension($_FILES[$fileTag]['name']);
        $upload = new RUploadHelper(array('file_name' => $picName, 'upload_path' => $uploadPath));

        $upload->upload($fileTag);

        if ($upload->error != '') {
            return $upload->error;
        } else {
            $this->picture = "files/images/groups/" . $upload->file_name;
            $this->save();
            RImageHelper::updateStyle($this->picture, static::getPicOptions());
            return true;
        }
    }

    public function increaseCounter()
    {
        if (isset($this->id)) {
            $counter = new Counter();
            $counter->increaseCounter($this->id, self::ENTITY_TYPE);
            return $counter;
        }
        return null;
    }

    public function deleteGroup()
    {
        if (isset($this->id) && $this->id != '') {
            $groupUsers = new GroupUser();
            $groupUsers->groupId = $this->id;

            $topics = new Topic();
            $topics->groupId = $this->id;
            $_topics = $topics->find();
            $comment = new Comment();
            foreach ($_topics as $topic) {
                $sql = "delete from {$comment->table} where {$comment->columns['topicId']} = {$topic->id}";
                Data::executeSQL($sql);
            }
            $sql = "delete from {$topics->table} where {$topics->columns['groupId']} = {$this->id}";
            Data::executeSQL($sql);

            $sql = "delete from {$groupUsers->table} where {$groupUsers->columns['groupId']} = {$this->id}";
            Data::executeSQL($sql);
            $friends = new FriendsGroup();
            $sql = "delete from {$friends->table} where {$friends->columns['groupId1']} = {$this->id} or {$friends->columns['groupId2']} = {$this->id} ";
            Data::executeSQL($sql);

            $this->delete();

            $counter = new Counter();
            $counter = $counter->loadCounter($this->id, self::ENTITY_TYPE);
            if ($counter != null)
                $counter->delete();

            return true;
        } else
            return false;
    }

    public static function inviteFriends($groupId, $user, $invitees = array(), $invitationMsg)
    {
        $group = Group::get($groupId);

        foreach ($invitees as $friendId) {
            $censor = new Censor();
            $censor->joinGroupApplication($friendId, $group->id);

            $msg = new Message();
            $content = RHtmlHelper::linkAction('user', $user->name, 'view', $user->id)
                . ' invited you to join group '
                . RHtmlHelper::linkAction('group', $group->name, 'detail', $group->id)
                . '&nbsp;&nbsp;'
                . RHtmlHelper::linkAction('group', 'Accept invitation', 'acceptInvite', $censor->id, array('class' => 'btn btn-xs btn-info'))
                . '</br>'
                . $invitationMsg;
            $content = RHtmlHelper::encode($content);
            Message::sendMessage('group', $user->id, $friendId, 'new group invitation', $content);

        }
    }

    /**
     * Recommend all selected groups to every selected users
     * @param $groups
     * @param $users
     */
    public static function recommendGroups($groups, $users, $words = '')
    {
        foreach ($users as $userId) {
            $html = '<div class="row recommend-groups">';
            foreach ($groups as $groupId) {
                $group = Group::get($groupId);
                if (null != $group) {
                    $censor = new Censor();
                    $censor = $censor->joinGroupApplication($userId, $group->id);
                    $html .= '<div class="col-lg-3 recommend-group-item" style="padding: 5px;">';
                    if (!isset($group->picture) || $group->picture == '') $group->picture = Group::$defaults['picture'];
                    $html .= RHtmlHelper::showImage($group->picture, $group->name);
                    $html .= '<br/>' . RHtmlHelper::linkAction('group', $group->name, 'detail', $group->id);
                    $html .= '<br/>' . RHtmlHelper::linkAction('group', 'Accept', 'accept', $censor->id, array('class' => 'btn btn-xs btn-success'));
                    $html .= '</div>';
                }
            }
            $html .= '</div>';
            $html .= '<div class="recommend-content">' . RHtmlHelper::encode($words) . '</div>';
            Message::sendMessage('system', 0, $userId, 'Groups recommendation', $html, date('Y-m-d H:i:s'));
        }
    }

    public static function getPicOptions()
    {
        return array(
            'path' => 'files/images/styles',
            'name' => 'groups',
            'width' => 200,
            'height' => 200
        );
    }
}
