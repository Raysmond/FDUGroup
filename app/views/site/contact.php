<?php
/**
 * Contact view file.
 * @author: songrenchu
 */
?>
<div class="panel panel-default">
    <div  id="developer" class="panel-heading">
        <h1 class="panel-title">Contact with FDUGroup team.</h1>
    </div>

    <div class="panel-body site-hook" id="developers-list">
        <h4>Developers</h4>
        <div class="user-item col-lg-3" style="overflow: hidden;text-align: center;">
            <a href="https://github.com/Raysmond/" target="_blank">
                <img src="<?=RHtmlHelper::siteUrl('public/images').'/ljk.jpg'?>" class="img-thumbnail" title="Raysmond">
            </a>
            <a title="admin" href="https://github.com/Raysmond/" target="_blank">Raysmond</a>
        </div>
        <div class="user-item col-lg-3" style="overflow: hidden;text-align: center;">
            <a href="https://github.com/RenchuSong/" target="_blank">
                <img src="<?=RHtmlHelper::siteUrl('public/images').'/src.jpg'?>"class="img-thumbnail"  title="Renchu Song">
            </a>
            <a title="admin" href="https://github.com/RenchuSong/" target="_blank">Renchu Song</a>
        </div>
        <div class="user-item col-lg-3" style="overflow: hidden;text-align: center;">
            <a href="https://github.com/wishstudio/" target="_blank">
                <img src="<?=RHtmlHelper::siteUrl('public/images').'/sxy.jpg'?>"class="img-thumbnail"  title="wishstudio">
            </a>
            <a title="admin" href="https://github.com/wishstudio/" target="_blank">wishstudio</a>
        </div>
        <div class="user-item col-lg-3" style="overflow: hidden;text-align: center;">
            <a href="https://github.com/junshiguo/" target="_blank">
                <img src="<?=RHtmlHelper::siteUrl('public/images').'/gjs.jpg'?>"class="img-thumbnail"  title="junshiguo">
            </a>
            <a title="admin" href="https://github.com/junshiguo/" target="_blank">Junshi Guo</a>
        </div>
        <div class="clearfix"></div>
        <div class="user-item  col-lg-3"></div>
        <div class="user-item  col-lg-3" style="overflow: hidden;text-align: center;">
            <a href="https://github.com/zyz282994112/" target="_blank">
                <img src="<?=RHtmlHelper::siteUrl('public/images').'/zyz.jpg'?>" class="img-thumbnail"  title="zyz282994112">
            </a>
            <br/>
            <a title="admin" href="https://github.com/zyz282994112/" target="_blank">Yizhou Zhang</a>
        </div>

        <div class="user-item col-lg-3" style="overflow: hidden;text-align: center;">
            <a href="http://www.renren.com/284019636/profile" target="_blank">
                <img src="<?=RHtmlHelper::siteUrl('public/images').'/wjh.jpg'?>" class="img-thumbnail"  title="Junhao Wu">
            </a>
            <br/>
            <a title="admin" href="http://www.renren.com/284019636/profile" target="_blank">Junhao Wu</a>
        </div>
        <div class="user-item  col-lg-3"></div>


        <div class="clearfix"></div>
        <br/>
        <h4 id="follow">Mail us</h4>
        <p>
            School of Computer Science, Fudan University<br/>
            825 Zhangheng Road, Pudong District, Shanghai, China (201203)<br/>
        </p><br/>
        <h4>Follow us on Github </srcylqh4>
        <p>
            <?=RHtmlHelper::link("FDUGroup github page",$githubLink,$githubLink);?>
        </p>
        <div class="user-item" style="overflow: hidden;text-align:left;">
            <a href="<?=$githubLink?>" target="_blank">
                <img src="<?=RHtmlHelper::siteUrl('public/images').'/QuickMark.png'?>" title="Scan This!" />
            </a>
        </div>
    </div>
</div>