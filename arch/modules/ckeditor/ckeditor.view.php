<?php if($show): ?>
    <textarea id="<?=$id?>" name="<?=$id?>" <?=RHtmlHelper::parseAttributes($attributes)?> >

    </textarea>

    <script>
        $(document).ready(function() {
            //var editor = CKEDITOR.replace( "<?=$id?>" );
            var path = "<?=$path?>";
            CKEDITOR.replace( "<?=$id?>", {
                //filebrowserBrowseUrl        : path+'/ckfinder/ckfinder.html',
                //filebrowserImageBrowseUrl   : path+'/ckfinder/ckfinder.html?Type=Images',
                //filebrowserFlashBrowseUrl   : path+'/ckfinder/ckfinder.html?Type=Flash',
                filebrowserUploadUrl        : path +'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl   : path +'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
                //filebrowserFlashUploadUrl   : path + '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
            });
        });
    </script>

<?php endif; ?>
