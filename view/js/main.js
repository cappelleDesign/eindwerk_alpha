$(init);
function init() {
    setListeners();
    $(document.body).mCustomScrollbar({
        theme: 'dark',
        scrollButtons: true
    });
}

function setListeners() {
    $('#inf-slider').on('click swipe keyup', function (event, slick, currentSlide) {
        $('.slider-left, .slider-right').stop().animate({blurRadius: 5}, {
            duration: 300,
            easing: 'swing',
            step: function () {
                $('.slider-left img, .slider-right img').css({
                    '-webkit-filter': 'blur(' + this.blurRadius + 'px)',
                    'filter': 'blur(' + this.blurRadius + 'px)'
                });
            }
        }, setPrevAndNext());
    });
    $('#newsfeed-nav .menu a').on('click', function () {
        $index = $('#newsfeed-nav li').index($(this).parent());
        $margin = $('#newsfeeds').width() * $index * -1;
        console.log($margin);
        $('#newsfeed-items').css({'margin-left': $margin});
        $('#newsfeed-nav li').removeClass('active');
        $(this).parent().addClass('active');
    });
}

function setPrevAndNext() {
    $currentIndex = $('.slick-current').data('slick-index');
    console.log($currentIndex);
    $prevNr = $currentIndex - 1;
    $nextNr = $currentIndex + 1;
    $prev = $('.slick-slide[data-slick-index="' + $prevNr + '"]').data('imgsrc');
    $next = $('.slick-slide[data-slick-index="' + $nextNr + '"]').data('imgsrc');

    $('.slider-left img').attr('src', $prev);
    $('.slider-right img').attr('src', $next);
    $('.slider-left, .slider-right').animate({blurRadius: 5}, {
        duration: 300,
        easing: 'swing',
        step: function () {
            $('.slider-left img, .slider-right img').css({
                '-webkit-filter': 'blur(' + this.blurRadius + 'px)',
                'filter': 'blur(' + this.blurRadius + 'px)'
            });
        }
    });
}