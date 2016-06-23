var noMcS = true;
function reviewPageInit() {    
    $(window).resize(function () {
        reviewRepaint();
    });
    loadReviews(pictureMode, 1);
    reviewRepaint();
    setTimeout(function () {
        if (!$('body').hasScrollBar() && noMcS) {
            loadReviews(pictureMode, 2);
        }
    }, 1000);

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
        $h = $('#wrapper').height();
        if ($scroll.mcs.topPct >= 80) {
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

function pictureMode($offset, $w) {

    $('#reviews-overview-pt' + $offset).unitegallery({
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
        tile_height: 200,
        tile_enable_shadow: false,
        grid_padding: 0,
        grid_space_between_cols: 20,
        grid_num_rows: 9
    });
    $('#review-more-load').hide();
    Cookies.remove('isLoading');
}