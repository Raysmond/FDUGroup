<?php
/**
 * CategoryController class file.
 * @author: Raysmond
 */

class CategoryController extends BaseController
{
    public $layout = "index";
    public $defaultAction = "index";

    public $access = array(
        Role::ADMINISTRATOR => array('new', 'edit', 'admin'),
    );

    /**
     * View all groups under the category
     * @param string $categoryId
     */
    public function actionGroups($categoryId = '')
    {
        $category = null;
        if (!is_numeric($categoryId) || ($category = Category::get($categoryId)) === null) {
            $this->page404();
            return;
        }
        $page = Rays::getParam("page",1);
        $pageSize = 5;

        $groups = Group::getGroupsOfCategory($categoryId,($page-1)*$pageSize,$pageSize);

        $this->addCss("/public/css/group.css");
        $this->addJs("/public/js/masonry.pkgd.min.js");
        if(Rays::isAjax()){
            if (!count($groups)) {
                echo 'nomore';
            } else {
                $this->renderPartial("_groups_list", array("groups"=>$groups),false);
            }
            exit;
        }
        $this->render('groups', array('category' => $category, 'groups' => $groups), false);

    }

    /**
     * Category administration
     */
    public function actionAdmin()
    {
        $data = array();

        if (Rays::isPost()) {
            if (isset($_POST['sub_items'])) {
                $items = $_POST['sub_items'];
                if (is_array($items)) {
                    foreach ($items as $item) {
                        if (!is_numeric($item)) return;
                        else {
                            $cat = new Category();
                            $cat->id = $item;
                            $cat->load();
                            if ($cat->pid == 0) continue;
                            $cat->delete();
                        }
                    }
                }
            }

            if (isset($_POST['cat-name']) && isset($_POST['parent-id'])) {
                $name = trim($_POST['cat-name']);
                $pid = $_POST['parent-id'];
                if (is_numeric($pid)) {
                    if ($name == '') {
                        $this->flash('error', 'Category name cannot be blank.');
                    } else {
                        $parent = new Category();
                        $result = $parent->load($pid);
                        if ($result != null) {
                            $newCat = new Category();
                            $newCat->name = RHtmlHelper::encode(trim($name));
                            $newCat->pid = $pid;
                            $newCat->insert();
                            $this->flash('message', 'Category ' . $name . " was created successfully.");
                        } else {
                            $this->flash('error', 'Parent category not exists.');
                        }
                    }
                }
            }
        }

        $category = new Category();
        $category->pid = '0';
        $data['categories'] = $category->find();

        $this->layout = 'admin';
        $this->setHeaderTitle('Category administration');
        $this->render('admin', $data, false);
    }

}