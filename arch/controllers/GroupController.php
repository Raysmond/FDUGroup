<?php
/**
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 上午11:41
 */

class GroupController extends RController {
    public $layout = "index";
    public $defaultAction = "index";

    public function actionFind($userId = null)
    {
        $group = new Group();
        $groups = $group->find();
        $this->setHeaderTitle("Find Group");
        $this->render("view",$groups,false);
    }

    public function actionView($userId = null)
    {

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