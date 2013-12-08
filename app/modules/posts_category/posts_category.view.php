<div id="category-bar" class="row posts-category-wrapper">

    <ul class="posts-category">
        <?php
        foreach ($categories as $category) {
            ?>
            <li>
                <a class="btn btn-sx parent-category <?=($category->id==$id)?"active":""?>" href="<?= RHtmlHelper::siteUrl('post/find/' . $category->id) ?>">
                    <?= RHtmlHelper::showImage('files/images/category/' . $category->id . '.png', '', ['style' => 'width:24px;height:24px;']) ?>
                    &nbsp;
                    <?= $category->name ?>
                </a>
            </li>
        <?php
        }
        ?>
    </ul>

</div>