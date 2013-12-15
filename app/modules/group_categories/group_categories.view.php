<?php
/**
 * Group categories module view
 * @author: songrenchu
 */
?>
<div id="category-bar">
    <div id="category-parent-level-bar">
        <?php
        foreach($categories as $category){
            ?>
            <a class="btn btn-sx parent-category
            <?=in_array($category->id, $cid) ? 'active':''?>" href="<?=RHtmlHelper::siteUrl('category/groups/'.$category->id)?>">
                <?=RHtmlHelper::showImage('files/images/category/'.$category->id.'.png','', ['style'=>'width:24px;height:24px;'])?>&nbsp;
                <?=$category->name?>
            </a>
            <?php
        }
        ?>
        <a class="btn btn-sx parent-category" href="javascript:packCategory();">
            <?=RHtmlHelper::showImage('files/images/category/more.png', '', ['style'=>'width:24px;height:24px;'])?>&nbsp;
            更多...
        </a>
        <script>
            function packCategory() {
                $('#category-children-level-bar').slideToggle();
            }
        </script>
    </div>
    <div id="category-children-level-bar" style="display:none;">
        <?php
        foreach($categories as $category){
            $subCategory = $category->children();
        ?>
            <div class="category-children-container">
                <ul>
                <?php
                    foreach ($subCategory as $cat) {
                        echo '<li>'.RHtmlHelper::linkAction('category',$cat->name,'groups',$cat->id, ['class' => 'btn btn-sm children-category '. (in_array($cat->id, $cid) ? 'active':''),]).'</li>';
                    }
                ?>
                </ul>
            </div>
        <?php
        }
        ?>
    </div>
</div>
