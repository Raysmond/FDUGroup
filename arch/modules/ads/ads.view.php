<?php
/**
 * Created by PhpStorm.
 * User: songrenchu
 */
?>
<div class="panel panel-info">
    <div class="panel-body ads-container" style="margin:5px;padding:0;overflow: hidden;">
        <input type="hidden" id="ad_number" value="<?=count($ads);?>"/>
        <?php
        $c = 0;
        foreach ($ads as $ad) {
            echo '<div class="Ad_List" id="Ad_'.$c.'" adid="'.$ad->id.'" title="'.$ad->title.'" >';
            echo RHtmlHelper::decode($ad->content);
            echo '</div>';
            $c++;
        }
        ?>
        <a class="ads-prev" href="javascript:ad_loop_prev()">Prev</a>
        <a class="ads-next" href="javascript:ad_loop_next()" style="float: right;">Next</a>

    </div>
    <script language="javascript">
        var current_ad = 0, ad_total_number = 0;
        $(document).ready(
            function(){
                current_ad = 0;
                ad_total_number = $('#ad_number').val();
                $('.Ad_List').hide();
                $('#Ad_0').show();
                $('.Ad_List img').each(
                    function() {
                        $(this).css('width','250px');
                        $(this).css('height','auto');
                    }
                );
                setTimeout('ad_loop_display()',10000);
            }
        );

        //$('.Ad_List a').attr('target','_blank');

        $('.Ad_List a').click(
            function() {
                var element = $(this).parent();
                while ($(element).attr('class') != 'Ad_List') {
                    element = $(element).parent();
                }
                $.ajax({
                    type: 'POST',
                    url: '<?=RHtmlHelper::siteUrl('ads/hitAd')?>',
                    data: {'adId':$(element).attr('adid')}
                });
            }
        );

        function ad_loop_next(){
            ad_loop_show(current_ad + 1);
        }

        function ad_loop_prev(){
            ad_loop_show(current_ad - 1);
        }

        function ad_loop_show(ad){
            $(('#Ad_'+current_ad)).hide();
            if(ad==ad_total_number) ad = 0;
            else if(ad==-1) ad = ad_total_number - 1;
            current_ad = ad;
            $(('#Ad_'+current_ad)).show();
        }

        function ad_loop_display() {
            $(('#Ad_'+current_ad)).hide();
            current_ad++;
            if (current_ad == ad_total_number) {
                current_ad = 0;
            }
            $(('#Ad_'+current_ad)).show();
            setTimeout('ad_loop_display()',10000);
        }
    </script>
</div>