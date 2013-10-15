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
            return;
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
        $category = new Category();
        $categories =  $category->find();
        $data = array('categories'=>$categories);
        if($this->getHttpRequest()->isPostRequest()){
            $form = $_POST;
            $rules = array(
                array('field'=>'group-name','label'=>'Group name','rules'=>'trim|required|min_length[5]|max_length[30]'),
                array('field'=>'category','label'=>'Category','rules'=>'required'),
                array('field'=>'intro','label'=>'Group Introduction','rules'=>'trim|required|min_length[10]')
            );

            $validation = new RFormValidationHelper($rules);
            if($validation->run()){
                // success
                $group = new Group();
                $group = $group->buildGroup($_POST['group-name'],$_POST['category'],$_POST['intro'],Rays::app()->getLoginUser()->id);
                if(isset($_FILES['group_picture'])&&($_FILES['group_picture']['name']!=''))
                {
                    $upload = new RUploadHelper(array('file_name'=>'group_'.$group->id.RUploadHelper::get_extension($_FILES['group_picture']['name']),
                        'upload_path'=>Rays::getFrameworkPath().'/../public/images/groups/'));
                    $upload->upload('group_picture');
                    if($upload->error!=''){
                        echo '<pre>';
                        print_r($upload);
                        echo '</pre>';
                        $this->flash("error",$upload->error);
                    }
                    else{
                        $group->picture = "public/images/groups/".$upload->file_name;
                        $group->update();
                    }
                }
                $this->flash("message","Group was built successfully.");
                $this->redirectAction('group','view',Rays::app()->getLoginUser()->id);
                return;
            }
            else{
                // validation failed
                $data['validation_errors'] = $validation->getErrors();
                $data['buildForm'] = $form;
            }
        }
        else{
            //
        }
        $this->render('build',$data,false);
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
            return;
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
            return;
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