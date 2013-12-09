<?php
/**
 * RatingController class file.
 * @author: Raysmond
 */

class RatingController extends BaseController
{
    public $layout = "index";
    public $defaultAction = "index";

    public $access = array(
        Role::AUTHENTICATED => array('plus'),
        Role::ADMINISTRATOR => array(),
    );

    public function actionPlus()
    {
        if (Rays::isAjax()) {
            $result = ["result"=>false];
            if (isset($_POST['plusId']) && isset($_POST['plusType'])) {
                if (is_numeric($_POST['plusId'])) {
                    $plusId = $_POST['plusId'];
                    $userId = 0;
                    if (Rays::isLogin())
                        $userId = Rays::user()->id;
                    $host = Rays::httpRequest()->getUserHostAddress();

                    switch ($_POST['plusType']) {
                        case Topic::$entityType:
                            if (Topic::get($plusId) !== null) {
                                $plus = new RatingPlus(Topic::$entityType, $plusId, $userId,$host);
                                if($plus->rate()){
                                    $result = ["result"=>true,"counter"=>$plus->getCounter()->value];
                                }
                            }
                            break;
                        case Group::ENTITY_TYPE:
                            if (Group::get($plusId) !== null) {
                                $plus = new RatingPlus(Group::ENTITY_TYPE, $plusId, $userId, $host);
                                if($plus->rate()){
                                    $result = ["result"=>true,"counter"=>$plus->getCounter()->value];
                                }
                            }
                            break;
                    }
                }
            }
            echo json_encode($result);
            exit;
        }
    }
} 