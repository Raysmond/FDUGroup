<ul class="nav nav-pills nav-stacked">
    <li <?=($currentUrl=='user/home')?'class="active"':""?>>
        <?=RHtmlHelper::linkAction('user','Home page','home')?>
    </li>
    <li <?=($currentUrl=='user/profile')?'class="active"':""?>>
        <?=RHtmlHelper::linkAction('user','Profile','view',$user->id)?>
    </li>
    <?php
    if(($count = $user->countUnreadMsgs())==0){
        echo "<li ".($currentUrl=='message/view'?'class="active"':"").">".RHtmlHelper::linkAction("message","Messages","view",null)."</li>";
    }
    else
    {
        echo '<li '.($currentUrl=='message/view'?'class="active"':"").'><a href="'.RHtmlHelper::siteUrl('message/view').'">';
        echo 'Messages&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="badge">'.$count.'</span></a></li>';
    }
    ?>
</ul>