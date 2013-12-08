<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">
            <?=isset($category)?$category->name:"Find posts" ?>
        </h1>
    </div>

    <div class="panel-body">
        <?php
        if (!empty($posts))
            $this->renderPartial("_common._posts_list", array('topics' => $posts));
        else echo '<p>No posts found!</p>';
        ?>
        <div>
            <?= isset($pager) ? $pager : "" ?>
        </div>
    </div>
</div>