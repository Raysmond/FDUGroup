<?php

$form = array();
if (isset($searchForm)) {
    $form = $searchForm;
}
$lastSearchStr = isset($searchstr) ? $searchstr : "";
if ($lastSearchStr != '')
    $lastSearchStr = urlencode($lastSearchStr);
echo '<div>';
?>
<div class="row search-groups-form">
        <?= RFormHelper::openForm('group/find', array('class' => 'find-group-form')); ?>
        <div class="col-lg-4">
            <div class="input-group">
                <input type="text" class="form-control" id="search-str" name="searchstr"
                       value="<?php echo urldecode($lastSearchStr); ?>"
                       placeholder="Search Groups">
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit">Go!</button>
              </span>
            </div>
        </div>
        <?= RFormHelper::endForm() ?>
</div>

<?php
echo '<div class="clearfix" style="margin-bottom: 10px;"></div>';

echo '<div class="row find-groups">';
$groups = $data['group'];
if (!count($groups)) {
    echo '<div>&nbsp;&nbsp;No groups found!</div>';
}
?>
<div id="waterfall-groups" class="waterfall">
    <?php
        $this->renderPartial("_groups_list",array('groups'=>$groups),false);
    ?>
</div>
</div>
<div class="clearfix"></div>
<a id="load-more-groups" href="javascript:loadMoreGroups()" class="btn btn-lg btn-primary btn-block">Load more groups</a>
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