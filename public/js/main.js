// main.js
$(document).ready(function() {
    $('[data-toggle=offcanvas]').click(function() {
        $('.row-offcanvas').toggleClass('active');
    });
    $('#account-dropdown').append('<b class="caret"></b>');
    $('#');
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