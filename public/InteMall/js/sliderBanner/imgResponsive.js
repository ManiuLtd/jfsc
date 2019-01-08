//Banner
var imgHeight = 600;
function resizeWindow() {
    var windowWidth = $(window).width();
    switch (true) {
        case (windowWidth > 800 && windowWidth < 1200):
            $('.img-responsive').each(function () {
                if ($(this).attr('data-m-src')) {
                    $(this).attr('src', $(this).attr('data-m-src'));
                    $(this).css('opacity', '0');
                    $(this).load(function () {
                        imgHeight = $(this).parents('li').height();
                        $(this).css('opacity', '1');
                        $('#banner,.sy-box').css('height', imgHeight);
                    });
                }
            })
            break;
        case (windowWidth < 1000):
            $('.img-responsive').each(function () {
                if ($(this).attr('data-xs-src')) {
                    $(this).attr('src', $(this).attr('data-xs-src'));
                    $(this).css('opacity', '0');
                    $(this).load(function () {
                        imgHeight = $(this).parents('li').height();
                        $(this).css('opacity', '1');
                        $('#banner,.sy-box').css('height', imgHeight);
                    });
                }
            })
            break;
        default:
            $('.img-responsive').each(function () {
                if ($(this).attr('data-default-src')) {
                    $(this).attr('src', $(this).attr('data-default-src'));
                    $(this).css('opacity', '0');
                    $(this).load(function () {
                        imgHeight = $(this).parents('li').height();
                        $(this).css('opacity', '1');
                        $('#banner,.sy-box').css('height', imgHeight);
                    });
                }
            })
    }
}
resizeWindow();

$(window).resize(function () {
    resizeWindow();
});