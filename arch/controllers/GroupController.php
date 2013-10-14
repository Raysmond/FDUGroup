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
        if(! Rays::app()->isUserLogin()){
            $this->flash("message","Please login first!");
            $this->redirectAction('user','login');
        }
        $userGroup = new GroupUser();
        $userGroup = $userGroup->userGroups($userId);
        $this->setHeaderTitle("My Groups");
        $this->render("view",$userGroup,false);
    }

    public function actionDetail($groupId){
        $this->setHeaderTitle("Group details");
        $group = new Group();
        $group->load($groupId);
        $group->category->load();
        $group->groupCreator->load();
        $this->render('detail',array('group'=>$group),false);

    }

    public function actionBuild()
    {
        $this->setHeaderTitle("Build my group");
        if($this->getHttpRequest()->isPostRequest()){
            $form = $_POST;
            $rules = array();
            $validation = new RFormValidationHelper($rules);
            if($validation->run()){
                // success
                $group = new Group();
                $group->setDefaults();
                $group->name = $form['group-name'];
                $group->categoryId = $form['category']; //initial id 0 : other category to be decided by sys manager
                $group->intro = $form['intro'];
                $group->creator = Rays::app()->getLoginUser()->id;
                $group->insert();
                $group = $group->find()[0];

                $groupUser = new GroupUser();
                $groupUser->groupId = $group->id;
                $groupUser->userId = $group->creator;
                date_default_timezone_set(Rays::app()->getTimeZone());
                $groupUser->joinTime = date('Y-m-d H:i:s');
                $groupUser->status = 1;
                $groupUser->insert();

                $this->flash("message","Group was built successfully.");
                $this->redirectAction('group','view',Rays::app()->getLoginUser()->id);
            }
            else{
                // failed
                $this->flash("error","Errors.");
            }
        }
        else{
            $category = new Category();
            $categories =  $category->find();
            $this->render('build',array('categories'=>$categories),false);
            return;
        }
        $this->render('build',null,false);
    }

    public function actionEdit($groupId=null)
    {
        $this->render('edit',array('groupId'=>$groupId),false);
    }

    public function actionJoin($groupId=null)
    {
        if(Rays::app()->isUserLogin()==false){
            $this->flash("message","Please login first.");
            $this->redirectAction('user','login');
        }
        else{
            $groupUser = new GroupUser();
            $groupUser->groupId = $groupId;
            $groupUser->userId = Rays::app()->getLoginUser()->id;
            date_default_timezone_set(Rays::app()->getTimeZone());
            $groupUser->joinTime = date('Y-m-d H:i:s');
            $groupUser->status = 1;
            $groupUser->insert();

            $group = new Group();
            $group->load($groupId);
            $group->memberCount++;
            $group->update();

            $this->flash("message","Congratulations. You have joined the group successfully.");
            $this->redirectAction('group','view',Rays::app()->getLoginUser()->id);
        }
    }

    public function actionExit($groupId=null)
    {
        if(Rays::app()->isUserLogin()==false){
            $this->flash("message","Please login first.");
            $this->redirectAction('user','login');
        }
        else{
            $groupUser = new GroupUser();
            $groupUser->groupId = $groupId;
            $groupUser->userId = Rays::app()->getLoginUser()->id;

            $group = new Group();
            $group->load($groupId);
            $group->memberCount--;
            $group->update();

            $groupUser->delete();

            $this->flash("message","You have exited the group successfully.");
            $this->redirectAction('group','view',Rays::app()->getLoginUser()->id);
        }
    }
}