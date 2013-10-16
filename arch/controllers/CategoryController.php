<?php
/**
 * CategoryController class file.
 * @author: Raysmond
 */

class CategoryController extends RController{
    public $layout = "index";
    public $defaultAction = "index";

    public $access = array(
        Role::ADMINISTRATOR=>array('new','edit'),
    );

    /**
     * All categories page
     */
    public function actionIndex()
    {
        $this->setHeaderTitle("Categories");
    }

    /**
     * View all groups under the category
     * @param string $categoryId
     */
    public function actionGroups($categoryId='')
    {
        if($categoryId==''){
            Rays::app()->page404();
        }
        $category = new Category();
        $category->load($categoryId);
        if($category->id==''){
            Rays::app()->page404();
        }
        else{
            $groups = new Group();
            $groups->categoryId = $categoryId;
            $groups = $groups->find();
            $this->render('groups',array('category'=>$category,'groups'=>$groups),false);
        }
    }

    /**
     * Create a new category
     * @access administrator
     */
    public function actionNew($editId = '')
    {
        $this->layout = 'admin';
        $data = array();
        if($this->getHttpRequest()->isPostRequest())
        {
            $rules = array(
                array('field'=>'name','label'=>'Category name','rules'=>'trim|required|min_length[2]|max_length[20]'),
                array('field'=>'parent','label'=>'Category parent','rules'=>'trim|required|number'),
            );
            $validation = new RFormValidationHelper($rules);
            if($validation->run())
            {
                $cat = new Category();
                $cat->load($_POST['parent']);

                if($cat->id!=''){
                    $new = new Category();
                    $new->name = $_POST['name'];
                    $new->pid = $_POST['parent'];

                    // edit category if id is set
                    if(isset($_POST['id'])&&$_POST['id']!='')
                    {
                        $new->id = trim($_POST['id']);
                        $new->update();
                        $this->flash("message","Category ".RHtmlHelper::linkAction('category',$_POST['name'],'groups',$new->id)." was updated successfully.");
                    }
                    else
                    {   // new category
                        $new->insert();
                        $this->flash("message","Category ".$_POST['name']." was created successfully.");
                    }
                }
            }
            else{
                $data['validation_errors'] = $validation->getErrors();
                $data['newForm'] = $_POST;
            }
        }
        else
        {
            if($editId!='')
            {
                $cat = new Category();
                $cat->load($editId);
                if(!isset($cat->id)||$cat->id==''){
                    $this->flash("error","No such category");
                }
                else{
                    $form = array();
                    $form['id'] = $cat->id;
                    $form['parent'] = $cat->pid;
                    $form['name'] = $cat->name;
                    $data['newForm'] = $form;
                }
            }
            else
            {
                // do some thing
            }
        }

        $this->setHeaderTitle("Create new Category");
        $this->render('new_or_edit',$data,false);
    }

    /**
     * Edit category
     * @access administrator
     * @param $editId
     */
    public function actionEdit($editId)
    {
        $this->layout = 'admin';
        $this->actionNew($editId);
    }

}