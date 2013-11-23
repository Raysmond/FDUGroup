<?php
/**
 * Created by PhpStorm.
 * User: Raysmond
 * Date: 13-11-23
 * Time: PM4:28
 */

class FileController extends RController{

    public $access = array(Role::AUTHENTICATED => array('upload'));

    public function actionUploadImage(){
        $fileTag = 'upload';
        $user = Rays::app()->getLoginUser();
        if(isset($_FILES[$fileTag])){
            $path = Rays::getFrameworkPath() . "/../public/userfiles/u_".$user->id."/";
            if(!file_exists($path)){
                mkdir($path);
            }
            $file = $path.$_FILES[$fileTag]['name'];
            $name = $_FILES[$fileTag]['name'];
            $extension = RUploadHelper::get_extension($_FILES[$fileTag]['name']);
            if(file_exists($file)){
                $count = 0;
                while(true){
                    $_name = RUploadHelper::get_name($name).'_'.$count.$extension;
                    $_file = $path.$_name;
                    if(!file_exists($_file)){
                        $name = $_name;
                        break;
                    }
                    $count++;
                }
            }
            $upload = new RUploadHelper(array("file_name" => $name, "upload_path" => $path));
            $upload->upload($fileTag);

            if ($upload->error != '') {
                echo $upload->error;
                //$this->flash("error", $upload->error);
            } else {
                // success
                $uri = "public/userfiles/u_".$user->id."/".$upload->file_name;
                echo $uri;
            }
        }
        exit;
    }
} 