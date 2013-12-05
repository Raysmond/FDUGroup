<?php
/**
 * Group categories module view
 * @author: Raysmond
 */
?>
<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title"><?php echo $title; ?></h3></div>
    <div class="panel-body">
        <?php
            foreach($categories as $category){
                    if($category->pid!=0)
                        continue;
                    echo " • ".RHtmlHelper::linkAction('category',$category->name,'groups',$category->id)."<br/>";
                    $subCategories = $category->children();
                    foreach($subCategories as $cat){
                        echo RHtmlHelper::linkAction('category',$cat->name,'groups',$cat->id)."  ";
                    }
                    echo '<br/>';

            }
        ?>
    </div>
</div>