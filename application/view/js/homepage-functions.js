$(homeInit);
function homeInit() {
    getReviews(getNewsfeedItems);
    
}

function setHomeListeners() {    
    $(window).resize(function () {
        homePageRepaint();
    });
    $('#inf-slider').on('click swipe keyup', function (event, slick, currentSlide) {
        $('.slider-left, .slider-right').stop().fadeOut('fast').promise().done(function () {
            setPrevAndNext();
        });
    });
    $('#newsfeed-nav .menu a').on('click', function (e) {
        e.preventDefault();
        $index = $('#newsfeed-nav li').index($(this).parent());
        $margin = $('#newsfeeds').width() * $index * -1;
        $('#newsfeed-items').css({'margin-left': $margin});
        $('#newsfeed-nav li').removeClass('active');
        $(this).parent().addClass('active');
    });
    homePageRepaint();

}
function homePageRepaint() {    
    setCorrectSliderPics();
    setCorrectNewsfeedPics();
}
function setPrevAndNext() {
    $w = $(window).width();
    $currentIndex = $('.slick-current').data('slick-index');
    $prevNr = $currentIndex - 1;
    $nextNr = $currentIndex + 1;
    $prev = $('.slick-slide[data-slick-index="' + $prevNr + '"]').data('img-src');
    $next = $('.slick-slide[data-slick-index="' + $nextNr + '"]').data('img-src');
    $('.slider-left img').attr('src', $prev);
    $('.slider-right img').attr('src', $next);
    $('.slider-left, .slider-right').stop().fadeIn('fast');
}
function setCorrectSliderPics() {
    $.getScript($viewRoot + '/js/handlers/img-handler.js', function () {
        setSliderPics();
        fireSlider();
    });
}
function setCorrectNewsfeedPics() {
    $.getScript($viewRoot + '/js/handlers/img-handler.js', function () {
        setNewsfeedPics();
    });
}
function fireSlider() {
    if (!$('.slick-slider').length) {
        $('#inf-slider').slick({
            prevArrow: '<div class="slider-left"><img src=""><i class="fa fa-chevron-left"></i></div>',
            nextArrow: '<div class="slider-right"><img src=""><i class="fa fa-chevron-right"></i></div>',
            responsive: [
                {
                    breakpoint: 1041,
                    settings: "unslick"
                }
            ]
        });
        setPrevAndNext();
    }
}

function getReviews(getNewsfeedItems) {
    $.getScript($viewRoot + '/js/handlers/review-json-handler.js', function () {
        getHomeReviews();
        getNewsfeedItems(setHomeListeners);
    });
}

function getNewsfeedItems(setHomeListeners) {
    $.getScript($viewRoot + '/js/handlers/newsfeed-json-handler.js', function () {
    });
}

//getNewsfeedItems();
//    setHomeListeners();
//    homePageRepaint();