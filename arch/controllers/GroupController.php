<?php
/**
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 上午11:41
 */

class GroupController extends RController {
    public $layout = "index";
    public $defaultAction = "index";

    /*
     * actionFind: find groups/show all groups
     */
    public function actionFind($userId = null)
    {
        $group = new Group();
        $groups = $group->find();
        $this->setHeaderTitle("Find Group");
        $this->render("find",$groups,false);
    }

    /*
     * actionView: view my groups
     */
    public function actionView($userId = null)
    {
        if($userId == null){
            $this->redirect();
            return null;
        }
        $userGroup = new GroupUser();
        $userGroup = $userGroup->userGroups($userId);
        $this->setHeaderTitle("My Groups");
        $this->render("view",$userGroup,false);
    }

    public function actionBuild()
    {

    }

    public function actionJoin()
    {

    }

    public function actionExit()
    {

    }
}