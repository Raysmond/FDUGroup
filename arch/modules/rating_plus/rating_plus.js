/**
 * Created by Raysmond on 13-11-25.
 */

function plusEntity(url,entityType,entityId){
    $.ajax({
        type: "POST",
        url: url,
        data: {'plusType': entityType,'plusId': entityId}
    }).done(function(data){
            alert(data);
        });
}