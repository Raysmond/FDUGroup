// main.js
$(document).ready(function() {
    $('[data-toggle=offcanvas]').click(function() {
        $('.row-offcanvas').toggleClass('active');
    });
    $('#account-dropdown').append('<b class="caret"></b>');
});