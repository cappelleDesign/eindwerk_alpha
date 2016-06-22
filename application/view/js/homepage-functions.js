$(homeInit);
function homeInit() {
    $(document.body).mCustomScrollbar("destroy");
    getHomePageObjects(getHomeNewsfeedsIni, setHomeListeners, dispNotif);
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
    setSliderPics();
    fireSlider();
}
function setCorrectNewsfeedPics() {
    setNewsfeedPics();
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
function getHomeNewsfeedsIni(setHomeListeners, dispNotif) {
    getHomeNewsfeed(setHomeListeners, dispNotif);
}
function getHomePageObjects(getHomeNewsfeedsIni, setHomeListeners, dispNotif) {
    getHomeReviews(getHomeNewsfeedsIni, setHomeListeners, dispNotif);
}