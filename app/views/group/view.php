<div class="row panel panel-default">
    <div class="panel-heading"><b>My Groups</b></div>
    <div class="panel-body panel-my-group">
<?php
/**
 * show my groups
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 下午1:53
 */

    echo RHtmlHelper::linkAction('group','Build my group','build',null,array('class'=>'btn btn-success'));

    if(!count($groups)){
        echo "<p>You have not joint any groups!</p>";
    }
?>
        <div id="waterfall-groups" class="waterfall">
            <?php
            $this->renderPartial("_groups_list",$data,false);
            ?>
        </div>

        <!--script>
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
        </script-->
    </div>
</div>

<script>
    var $container = $('#waterfall-groups');
    var curPage = 1;
    var loadCount = 0;
    var isLoading = false;
    $(document).ready(function(){
        $container.masonry({
            columnWidth: 0,
            itemSelector: '.item'
        });

        $(window).scroll(function(){
            var height = $("#load-more-groups").position().top;
            var curHeight = $(window).scrollTop() + $(window).height();
            if(loadCount<4&&!isLoading&&curHeight>=height){
                loadMoreGroups();
            }
        });
    });


    function loadMoreGroups(){
        isLoading = true;
        $.ajax({
            url: "<?=RHtmlHelper::siteUrl('group/find') ?>",
            type: "post",
            data:{page: ++curPage,searchstr: $("#search-str").val()},
            success: function(data){
                var $blocks = jQuery(data).filter('div.item');
                $("#waterfall-groups").append($blocks);
                $("#waterfall-groups").masonry('appended',$blocks);
                isLoading = false;
                loadCount++;
            }
        });
    }

</script>