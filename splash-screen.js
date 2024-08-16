jQuery(document).ready(function($) {
    $('body').addClass('splash-screen');
    $('#enter-homepage').click(function() {
        $('#custom-splash-screen').fadeOut(500, function() {
            $(this).remove();
            $('body').removeClass('splash-screen');
        });
    });
});
