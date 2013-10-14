<div class="panel panel-info">
    <div class="panel-heading"><h3 class="panel-title">New Users</h3></div>
    <div class="panel-body">
        This is new users module<br/>
<?php
foreach($users as $user){
    echo RHtmlHelper::linkAction('user',$user->name,'view',array('uid'=>$user->id))." ";
}
?>

   </div>
    </div>