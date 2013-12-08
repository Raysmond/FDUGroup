// main.js
$(document).ready(function() {
    $('[data-toggle=offcanvas]').click(function() {
        $('.row-offcanvas').toggleClass('active');
    });
    $('#account-dropdown').append('<b class="caret"></b>');

    $(".posts-list .topic-item .topic-content img").css("maxWidth","560px").css("height","auto");

});

var checkAllFlag = false;

function checkReverse(name) {
    if (!checkAllFlag) {
        checkAll(name);
    } else {
        checkClearAll(name);
    }
    checkAllFlag = !checkAllFlag;
}

function checkAll(name) {
    var el = document.getElementsByTagName('input');
    var len = el.length;
    for(var i=0; i<len; i++) {
        if((el[i].type=="checkbox") && (el[i].name==name)) {
            el[i].checked = true;
        }
    }
}
function checkClearAll(name) {
    var el = document.getElementsByTagName('input');
    var len = el.length;
    for(var i=0; i<len; i++) {
        if((el[i].type=="checkbox") && (el[i].name==name)) {
            el[i].checked = false;
        }
    }
}


function rays_ajax_post(url, type, params, beforeSubmit, callback){
    var before = true;
    if(typeof beforeSubmit == 'function') before = beforeSubmit(params);
    if(before!=false){
        if(typeof before == 'object' && before.hasOwnProperty('params')){
            params = before.params;
        }
        $.ajax({type: type, url: url, data: params}).done(callback);
    }
}

/*
function before_delete(params){
    // change param before ajax submit
    var result = new Object();
    result.params = 'hello';
    return result
}

function after_delete(data){
    alert(data);
}*/