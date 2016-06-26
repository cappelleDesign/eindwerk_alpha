var noMcS = true;
var vidW;
var vidCar;
function reviewPageInit() {
    $(window).resize(function () {
        reviewRepaint();
    });
    $(window).scroll(function () {
        scrolled(false);
    });
    loadReviews(pictureMode, 1);
    reviewRepaint();
    setTimeout(function () {
        if (!$('body').hasScrollBar() && noMcS) {
            loadReviews(pictureMode, 2);
        }
    }, 2000);
}
function reviewSpecificInit() {
    vidW = getOptimalVideoWidth();
    $(window).resize(function () {
        vidW = getOptimalVideoWidth();
        reviewSpecificRepaint();
    });
    $slides = getOptimalCarousel();
    buildVid();
    $('#review-carousel').slick({
        infinite: true,
        slidesToShow: $slides,
        prevArrow: '<div id="review-carousel-prev" class="carousel-arrow"><i class="fa fa-caret-left"></i><div>',
        nextArrow: '<div id="review-carousel-nxt" class="carousel-arrow"><i class="fa fa-caret-right"></i><div>',
        responsive: [
            {
                breakpoint: 1040,
                settings: {
                    slidesToShow: 6
                }
            },
            {
                breakpoint: 811,
                settings: {
                    slidesToShow: 2
                }
            }
        ]
    });
    if ($(window).width() > 800) {
        $('#review-side-panel').height($('#main-review').height());
    }
    $('#user-score-set-mobile').knob({
        min: 0,
        max: 10,
        width: '50',
        height: '50',
        fgColor: "#ef4123",
        bgColor: "#231f20"
    });
    $('#user-score-set').knob({
        min: 0,
        max: 10,
        width: $('#user-score-container').width(),
        height: $('#user-score-container').width(),
        fgColor: "#ef4123",
        bgColor: "#231f20"
    });
    $('#send-user-score').on('click', function (e) {
        e.preventDefault();
        sendUserScore();
    });
}

function buildVid() {
    $el = $('#vidBuildTmp');
    $alt = $el.data('alt');
    $type = $el.data('type');
    $src = $el.data('src');
    $img = $el.data('image');
    $desc = $el.data('description');
    $vidId = $el.data('videoid');
    $revVid = '<div id="review-video"><img alt="' + $alt + '" ' +
            'data-type="youtube"  src="' + $src + '" ' +
            'data-image="' + $img + '" ' +
            'data-description="' + $desc + '" ' +
            'data-videoid="' + $vidId + '" style="display:none"></div>';
    $('#vidBuildTmp').after($revVid);
    $opt = {
        tile_width: vidW, //should be width of parent object(calculate)
        tile_height: 500,
        grid_padding: 0,
        tile_enable_border: false,
        tile_enable_shadow: false,
        tile_enable_textpanel: true,
        tile_textpanel_title_text_align: 'center',
        tile_textpanel_position: 'inside_top',
        tile_textpanel_always_on: true,
        tile_textpanel_source: 'desc_title',
        tile_textpanel_title_color: '#ef4123',
        tile_textpanel_title_font_size: 30,
        tile_textpanel_bg_opacity: 0.8};
    $('#review-video').unitegallery($opt);
}

function getOptimalVideoWidth() {
    $w = $('#main-review').width();
    return $w;
}

function reviewSpecificRepaint() {
    if ($('.ug-thumbs-grid').width() !== $('#main-review').width()) {
        $('#review-video').remove();
        $('.ug-gallery-wrapper.ug-lightbox').remove();
        buildVid();
    }
    if ($(window).width() > 810) {
        $curr = $('#carousel-filler') ? $('#carousel-filler div').length : 0;
        $slides = getOptimaSlides();
        $diff = $curr - $slides[2];
        if ($diff < 0) {
            addFiller($diff * -1);
        } else if ($diff > 0) {
            var $carouselI = 0;
            for ($carouselI; $carouselI < $diff; $carouselI++) {
                $('#carousel-filler div:last-child').remove();
            }
            $('#carousel-filler').width(100 * $('#carousel-filler div'));
        }
    } else {
        $('#carousel-filler').remove();
    }
}

function reviewRepaint() {
    $w = $(document).width();
    $(document.body).mCustomScrollbar('destroy');
    if ($w > 1100) {
        $(document.body).mCustomScrollbar({
            theme: 'scrollBarStyles',
            scrollButtons: {enable: true},
            callbacks: {
                onOverflowYNone: function () {
                    noMcS = true;
                },
                onOverflowY: function () {
                    noMcS = false;
                },
                whileScrolling: function () {
                    scrolled(this);
                }
            }
        });
    }
}

function scrolled($scroll) {
    if (!Cookies.get('isLoading')) {
        $h = $(window).height();
        if (typeof $scroll !== undefined && $scroll) {
            if ($scroll.mcs.topPct >= 80) {
                loadReviews();
            }
        } else if (($(document).height() - $h - $(window).scrollTop()) <= 100) {
            loadReviews();
        }
    }
}
function loadReviews() {
    Cookies.set('isLoading', '1');
    $offset = $('.rev-overview').last();
    $offset = $offset ? $offset.data('offset') : 0;
    getReviewsMore($offset);
}

function getOptimalWidth() {
    $w = $('#wrapper').width();
    $wind = $(window).width();
    if ($wind > 1000) {
        $w = $w / 3;
    } else if ($wind > 700) {
        $w = $w / 2;
    }
    return $w - 15;
}

function getOptimalCarousel() {
    if ($(window).width() <= 810) {
        $('#review-carousel').addClass('slides');
        return 2;
    }
    $optimalSlides = getOptimaSlides();
    $slides = $optimalSlides[0];
    $slidesPresent = $optimalSlides[1];
    if ($slidesPresent <= $slides) {
        $('#review-carousel').removeClass('slides');
        $('#review-carousel').width(100 * $slidesPresent);
        $extraSlides = $optimalSlides[2];
        addFiller($extraSlides);
        return $slidesPresent;
    } else {
        $('#review-carousel').addClass('slides');
    }
    return $slides;
}

function addFiller($extraSlides) {
    console.log($extraSlides);
    if (!$('#carousel-filler').length) {
        $('#review-carousel').after('<div id="carousel-filler"></div>');
    }
    var $carouselI = 0;
    for ($carouselI; $carouselI < $extraSlides; $carouselI++) {
        $('#carousel-filler').append('<div class="gallery-fake-img"><i class="fa fa-camera-retro"><i></div>');
    }
    $('#carousel-filler').width(100 * $('#carousel-filler div'));
}

function getOptimaSlides() {
    $fullW = $('#main-review').width() - 100;
    $slides = Math.floor(($fullW / 100));
    $slidesPresent = $('#review-carousel img').length;
    $extraSlides = $slides - $slidesPresent + 1;
    $optimalSlides = [$slides, $slidesPresent, $extraSlides];
    return $optimalSlides;
}

function pictureMode($offset, $w) {

    $('#reviews-overview-pt' + $offset).unitegallery({
        tile_enable_icons: false,
        tile_as_link: true,
        tile_link_newpage: false,
        tile_enable_textpanel: true,
        tile_textpanel_source: 'desc_title',
        tile_textpanel_title_text_align: 'center',
        tile_textpanel_always_on: true,
        tile_textpanel_bg_opacity: 0.8,
        tile_textpanel_title_font_size: 15,
        tile_border_color: '#333333',
        tile_width: $w,
        tile_height: $w - 200,
        tile_enable_shadow: false,
        grid_padding: 0,
        grid_space_between_cols: 20,
        grid_num_rows: 9
    });
    $('.load-more').hide();
    Cookies.remove('isLoading');
}
