<div class="panel panel-default">
    <div class="panel-heading">
        <?php
        if (isset($category)) {
            echo '<h1 class="panel-title">' . $category->name . '</h1>';
        }
        ?>
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