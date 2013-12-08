<?php
if(empty($groups)){
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            You have not joint any groups!
        </div>
    </div>
<?php
}
else{
    ?>
    <div>
        <div class="panel-my-group">
            <div id="waterfall-groups" class="waterfall">
                <?php
                $this->renderPartial("_groups_list",$data,false);
                ?>
            </div>
            <div class="clearfix"></div>
            <div class="load-more-groups-processing" id="loading-groups">
                <div class="horizon-center">
                    <img class="loading-24-24" src="<?=RHtmlHelper::siteUrl('/public/images/loading.gif')?>" /> loading...
                </div>
            </div>
            <a id="load-more-groups" href="javascript:loadMoreGroups()" class="btn btn-lg btn-primary btn-block">Load more groups</a>
        </div>
    </div>

    <script>
        var $container = $('#waterfall-groups');
        var curPage = 1;
        var loadCount = 0;
        var isLoading = false;
        var nomore = false;

        $(document).ready(function(){
            $('#loading-groups').hide(0);
            $('#load-more-groups').hide(0);
            $container.masonry({
                columnWidth: 0,
                itemSelector: '.item'
            });

            $(window).scroll(function(){
                var height = $("#load-more-groups").position().top;
                var curHeight = $(window).scrollTop() + $(window).height();
                if(!isLoading&&curHeight>=height && !nomore){
                    loadMoreGroups();
                }
            });
        });


        function loadMoreGroups(){
            isLoading = true;
            $('#loading-groups').show(0);
            //$('#load-more-groups').hide(0);
            $.ajax({
                url: "<?=RHtmlHelper::siteUrl('group/mygroups') ?>",
                type: "post",
                data:{page: ++curPage},
                success: function(data){
                    $('#loading-groups').hide(0);
                    //$('#load-more-groups').show(0);
                    if (data == 'nomore') {
                        nomore = true;
                        $('#loading-groups').hide(0);
                        //$('#load-more-groups').hide(0);
                        return;
                    }
                    var $blocks = jQuery(data).filter('div.item');
                    $("#waterfall-groups").append($blocks);
                    $("#waterfall-groups").masonry('appended',$blocks);
                    isLoading = false;
                    loadCount++;
                }
            });
        }

    </script>
<?php
}
?>
