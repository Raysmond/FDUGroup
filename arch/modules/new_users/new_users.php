<?php
/**
 * New users module file
 * @author: Raysmond
 */

class new_users_module extends RModule{

    /**
     * Override module_content method
     * @return string|void
     */
    public function module_content(){
        $content = "This is new users module<br/>";
        $users = $this->findNewUsers();
        foreach($users as $user){
            $content.= HtmlHelper::linkAction('user',$user->name,'view',array('uid'=>$user->id))." ";
        }
        return $content;
    }

    public function findNewUsers(){
        $user = new User();
        return $user->find(10,0,array('key'=>'u_id','order'=>'desc'));
    }
}