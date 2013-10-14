<?php
/**
 * CategoryController class file.
 * @author: Raysmond
 */

class CategoryController extends RController{
    public $layout = "index";
    public $defaultAction = "index";

    /**
     * All categories page
     */
    public function actionIndex()
    {

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
}