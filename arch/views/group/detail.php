<?php
/**
 * Group detail page
 * @author: Raysmond
 */
?>
<div class="jumbotron">
<h2><?php echo $group->name;?></h2>
<p>
Group creator: <?php echo RHtmlHelper::linkAction('user',$group->groupCreator->name,'view',$group->creator) ?> <br/>
Group category: <?php echo RHtmlHelper::linkAction('category',$group->category->name,'view',$group->category->id); ?> <br/>
Group introduction: <?php echo $group->intro; ?> <br/>
Group members: <?php echo $group->memberCount; ?> <br/>
Group created time: <?php echo $group->createdTime; ?> <br/>
</p>
</div>