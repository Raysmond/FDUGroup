<div class="row panel panel-default">
    <div class="panel-heading"><b>Latest posts</b></div>
    <div class="panel-body panel-my-group">
<?php
/**
 * show my groups
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 下午1:53
 */

    echo RHtmlHelper::linkAction('group','Build my group','build',null,array('class'=>'btn btn-success'));

    echo "<br/><br/>";

    if(!count($groups)){
        echo "<p>You have not joint any groups!</p>";
    }
?>
        <div id="waterfall-groups" class="waterfall">
            <?php
            $this->renderPartial("_groups_list",$data,false);
            ?>
        </div>

        <div class="alert alert-block alert-danger fade ">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>Quit group confirm!</h4>
            <p>
                This action cannot be undo! Are you going to quit the group right now?
            </p>
            <p>
                <span id="quit_link" style="display: none;"><?php echo Rays::app()->getBaseUrl()."/group/exit/" ?></span>
                <a id="alert-quit-group" class="btn btn-danger" href="#">Yes, quit now</a> <a class="btn btn-default" href="#">Cancel</a>
            </p>
        </div>

        <script>
            function confirmExit(groupId){
                alert(true);
                if(groupId!=''){
                    $('#alert-quit-group').attr('href',$('#quit_link').text() + groupId);
                }
            }
            $(document).ready(function() {
                $('.alert').bind('close.bs.alert', function () {
                    //$('.alert').removeClass('in').removeClass('fade');
                });
            });
        </script>
    </div>
</div>