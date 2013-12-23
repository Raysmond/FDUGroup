$(document).ready(function() {
    var path = $("#publish_form_path").val();
    var id = $("#publish_form_id").val();
    CKEDITOR.replace( id, {
        filebrowserUploadUrl        : path +'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl   : path +'/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        height: "120px"
    });
});