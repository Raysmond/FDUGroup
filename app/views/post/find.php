<div class="panel panel-default">
    <div class="panel-heading">
<!--        <h1 class="panel-title">Find posts</h1>-->
        <ul class="posts-category">
            <?php
            foreach($categories as $category){
                ?>
                <li>
                    <a class="btn btn-sx parent-category <?=in_array($category->id, $cid) ? 'active':''?>" href="<?=RHtmlHelper::siteUrl('category/groups/'.$category->id)?>">
                        <?=RHtmlHelper::showImage('files/images/category/'.$category->id.'.png','', ['style'=>'width:24px;height:24px;'])?>&nbsp;
                        <?=$category->name?>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>

    <div class="panel-body">

    </div>
</div>