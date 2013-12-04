<?php
echo '<div id="category-groups" class="row">';
if (!count($groups)) {
    echo '<div>&nbsp;&nbsp;No groups in the category!</div>';
}
?>
<div id="waterfall-groups" class="waterfall">
    <?php
    $this->renderPartial("_groups_list", array('groups' => $groups), false);
    ?>
</div>

<div class="clearfix"></div>
<a id="load-more-groups" href="javascript:loadMoreGroups()" class="btn btn-lg btn-primary btn-block">Load more
    groups</a>
</div>

<script>
    var $container = $('#waterfall-groups');
    var curPage = 1;
    var loadCount = 0;
    var isLoading = false;
    $(document).ready(function () {
        $container.masonry({
            columnWidth: 0,
            itemSelector: '.item'
        });

        $(window).scroll(function () {
            var height = $("#load-more-groups").position().top;
            var curHeight = $(window).scrollTop() + $(window).height();
            if (loadCount < 4 && !isLoading && curHeight >= height) {
                loadMoreGroups();
            }
        });
    });


    function loadMoreGroups() {
        isLoading = true;
        $.ajax({
            url: "<?=RHtmlHelper::siteUrl('category/groups/'.$category->id) ?>",
            type: "post",
            data: {page: ++curPage},
            success: function (data) {
                if (data == '') {
                    $("#category-groups").append("<span style='color: red;'>&nbsp;&nbsp;&nbsp;No more groups</span>");
                    $("#load-more-groups").hide();
                }
                var $blocks = jQuery(data).filter('div.item');
                $("#waterfall-groups").append($blocks);
                $("#waterfall-groups").masonry('appended', $blocks);
                isLoading = false;
                loadCount++;
            }
        });
    }

</script>