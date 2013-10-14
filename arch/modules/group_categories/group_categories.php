<?php
/**
 * Group categories module view
 * @author: Raysmond
 */
?>
<div class="panel panel-info">
    <div class="panel-heading"><h3 class="panel-title"><?php echo $title; ?></h3></div>
    <div class="panel-body">
        <?php
            foreach($categories as $category){
                if($category->id==$category->pid){
                    echo " • ".RHtmlHelper::linkAction('category',$category->name,'groups',$category->id)."<br/>";
                    foreach($categories as $cat){
                        if($cat->pid!=$cat->id&&$cat->pid==$category->id){
                            echo RHtmlHelper::linkAction('category',$cat->name,'groups',$cat->id)."  ";
                        }
                    }
                    echo '<br/>';
                }
            }
        ?>
    </div>
</div>