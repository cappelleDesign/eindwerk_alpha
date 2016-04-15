$(init);
function init() {
    setListeners();
    $(document.body).mCustomScrollbar({
        theme: 'dark',
        scrollButtons: true
    });
    $h = $(window).height();
    console.log($h);
    $('#wrapper').css('minHeight', $h+'px');
}

function setListeners() {
    $('#inf-slider').on('click swipe keyup', function (event, slick, currentSlide) {
        $('.slider-left, .slider-right').stop().fadeOut('fast').promise().done(function () {
            setPrevAndNext();
        });
    });
    $('#newsfeed-nav .menu a').on('click', function () {
        $index = $('#newsfeed-nav li').index($(this).parent());
        $margin = $('#newsfeeds').width() * $index * -1;
        $('#newsfeed-items').css({'margin-left': $margin});
        $('#newsfeed-nav li').removeClass('active');
        $(this).parent().addClass('active');
    });
    $('#account-panel > a:first-child').on({
        touchstart: function () {
            expandProfileMenu(this);
        }       
    });
}

function setPrevAndNext() {
    $currentIndex = $('.slick-current').data('slick-index');
    $prevNr = $currentIndex - 1;
    $nextNr = $currentIndex + 1;
    $prev = $('.slick-slide[data-slick-index="' + $prevNr + '"]').data('imgsrc');
    $next = $('.slick-slide[data-slick-index="' + $nextNr + '"]').data('imgsrc');

    $('.slider-left img').attr('src', $prev);
    $('.slider-right img').attr('src', $next);
    $('.slider-left, .slider-right').stop().fadeIn('fast');
}

function fireSlider() {
    if (!$('.slick-slider').length) {

        $('#inf-slider').slick({
            prevArrow: '<div class="slider-left"><img src=""><i class="fa fa-chevron-left"></i></div>',
            nextArrow: '<div class="slider-right"><img src=""><i class="fa fa-chevron-right"></i></div>',
            responsive: [
                {
                    breakpoint: 1,
                    settings: "unslick"
                }
            ]
        });
        setPrevAndNext();
    }
}

function expandProfileMenu($el) {
    $class = 'expanded';
    if ($($el).hasClass($class)) {
        $($el).removeClass($class);
        $('#account-panel').css('height', '24px');
    } else {
        $($el).addClass($class);
        $('#account-panel').css('height', '100px');
    }
}
