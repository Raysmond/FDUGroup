<?php
/**
 * MembersAction class
 * View all group members and group manager can manage the members like kicking somebody out.
 * @author: Raysmond
 * @date: 13-11-29
 */

class MembersAction extends RAction
{

    public function run()
    {
        $params = $this->getParams();
        $groupId = $params[0];

        if (!is_numeric($groupId)) {
            $this->getController()->page404();
            return;
        }

        if ($this->getController()->getHttpRequest()->isPostRequest()) {
            // remove members request
            if (isset($_POST['selected_members'])) {
                $ids = $_POST['selected_members'];
                if (is_array($ids)) {
                    $flag = true;
                    foreach ($ids as $id) {
                        if (!is_numeric($id)) {
                            $flag = false;
                            break;
                        }
                    }
                    if ($flag) {
                        GroupUser::removeUsers($groupId, $ids);
                    }
                }
            }
        }

        $group = new Group();
        if (($group = $group->load($groupId)) !== null) {
            $members = $group->groupUsers();
            $this->getController()->setHeaderTitle("Members in " . $group->name);
            $this->getController()->render(
                'members',
                array(
                    'members' => $members,
                    'manager' => (new User())->load($group->creator),
                    'group' => $group,
                    'memberCount' => count($members),
                    'topicCount' => Group::countTopics($groupId)),
                false);
        } else {
            $this->getController()->page404();
            return;
        }
    }
} 