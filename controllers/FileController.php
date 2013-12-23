<?php
/**
 * Class FileController
 *
 * @author: Raysmond
 */
class FileController extends RController{

    public $access = array(Role::AUTHENTICATED => array('upload'));

    public function actionUploadImage(){
        $fileTag = 'upload';
        $user = Rays::user();
        if(isset($_FILES[$fileTag])){
            $path = Rays::app()->getBaseDir() . "/files/userfiles/u_".$user->id."/";
            if(!file_exists($path)){
                mkdir($path);
            }
            $file = $path.$_FILES[$fileTag]['name'];
            $name = $_FILES[$fileTag]['name'];
            $extension = RUpload::get_extension($_FILES[$fileTag]['name']);
            if(file_exists($file)){
                $count = 0;
                while(true){
                    $_name = RUpload::get_name($name).'_'.$count.$extension;
                    $_file = $path.$_name;
                    if(!file_exists($_file)){
                        $name = $_name;
                        break;
                    }
                    $count++;
                }
            }
            $upload = new RUpload(array("file_name" => $name, "upload_path" => $path));
            $upload->upload($fileTag);

            if ($upload->error != '') {
                echo $upload->error;
                //$this->flash("error", $upload->error);
            } else {
                // success
                $uri = "files/userfiles/u_".$user->id."/".$upload->file_name;
                echo $uri;
            }
        }
        exit;
    }
} 