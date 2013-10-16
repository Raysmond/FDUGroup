<div class="panel panel-info">
    <div class="panel-heading"><h3 class="panel-title">Friends</h3></div>
    <div class="panel-body">
        <?php
        foreach($friends as $friend){
            echo RHtmlHelper::linkAction('user', $friend->name, 'view', $friend->id)."  ";
        }
        ?>
    </div>
    </div>
