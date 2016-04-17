$(init);
function init() {
    $('.noScript').remove();
    $('.no-js-push').removeClass('no-js-push');
    setListeners();
    $(document.body).mCustomScrollbar({
        theme: 'scrollBarStyles',
        scrollButtons: {enable: true}
    });
    $h = $(window).height();
    $('#wrapper').css('minHeight', $h + 'px');
    setSubMenuWidths();
}

function setListeners() {
    $('.fa-icon').on({
        mouseenter: function () {
            $('i', this).addClass('fa-flip-horizontal');
        },
        mouseleave: function () {
            $('i', this).removeClass('fa-flip-horizontal');
        }
    });
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
    $('.submenu-trigger').hover(
            function () {
                triggerSubMenu(this, true);
            },
            function () {
                triggerSubMenu(this, false);
            }
    );
    $('.submenu-trigger > a:first-child').on('touchstart', function (e) {
        e.preventDefault();
        if ($(this).next().hasClass('submenu-visible')) {
            triggerSubMenu($(this).parent(), false);
        } else {
            triggerSubMenu($(this).parent(), true);
        }
    });
}

function homePageRepaint() {
    setCorrectSliderPics();
    fireSlider();
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
    $.getScript('view/js/handlers/img--handler.js', function () {
        setSliderPics();
    });
}
function setCorrectNewsfeedPics() {
    $.getScript('view/js/handlers/img--handler.js', function () {
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

function expandProfileMenu($el) {
    $class = 'expanded';
    $height = getProfileMenuHeight();
    if ($($el).hasClass($class)) {
        $($el).removeClass($class);
        $('#account-panel').css('height', $height);
    } else {
        $($el).addClass($class);
        $('#account-panel').css('height', '100px');
    }
}

function getProfileMenuHeight() {
    $w = $(document).width();
    if ($w <= 1500) {
        return '21px';
    }
    return '24px';
}

function setSubMenuWidths() {
    $submenus = $('.submenu');
    $.each($submenus, function (i, $el1) {
        $($el1).hide();
        $children = $($el1).children();
        $devide = 100 / $children.length;
        $.each($children, function (i, $el2) {
            $($el2).css('width', $devide + '%');
        });
    });
}

function triggerSubMenu($el, $show) {
    $sub = $($el).data('submenu-trigger');
    $subEl = $('.submenu-' + $sub);
    if ($show) {
        $subEl.addClass('submenu-visible');
        $subEl.stop().fadeIn('slow');
    } else {
        $subEl.stop().fadeOut('slow', function () {
            $subEl.removeClass('submenu-visible');
        });
    }
}
