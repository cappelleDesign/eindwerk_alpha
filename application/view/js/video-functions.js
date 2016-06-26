var noMcS = true;
var twitchPlayer;
var playListId;
function liveInit() {
    getStream();
    $(window).resize(function () {
        getStream();
    });
}

function letsPlayInit() {
    playListId = 'PLy3mMHt2i7RKd4pf3eUDSOuJYuTA--YIL';
//    playListId = 'PLy3mMHt2i7RKpHRvK8bKuKWHh2kn33brm';
    $(window).resize(function () {
        letsPlayRepaint();
    });
    $(window).scroll(function () {
        scrolled(false);
    });
    loadVids();
    letsPlayRepaint();
    setTimeout(function () {
        if (!$('body').hasScrollBar() && noMcS) {
            loadVids();
        }
    }, 2000);
}
function letsPlayRepaint() {
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
                loadVids();
            }
        } else if (($(document).height() - $h - $(window).scrollTop()) <= 100) {
            loadVids();
        }
    }
}
function podcastInit() {
    $('.twitch-offline').css({
        display: 'block',
        width: $('.twitch-container').width() + 'px',
        height: $('.twitch-container').width() / 2 + 'px'
    });
}

function getStream() {
    $.getJSON('https://api.twitch.tv/kraken/streams/neoludus', function (channel) {

        if (channel["stream"] == null) {
//            showOffline();
            showPlayer();
        } else {
            showPlayer();
        }
    });
}

function showOffline() {
    twitchPlayer = null;
    $('.twitch-offline').css({
        display: 'block',
        width: $('.twitch-container').width() + 'px',
        height: $('.twitch-container').width() / 2 + 'px'
    });
}

function showPlayer() {
    if (!twitchPlayer) {
        twitchPlayer = new Twitch.Player('neoludus-twitch', {
            channel: 'neoludus',
            width: $('.twitch-container').width(),
            height: $('.twitch-container').width() / 2
        });
    }
}

function loadVids() {
    Cookies.set('isLoading', '1');
    $offset = $('.video-overview').last();
    $offset = $offset.length ? $offset.data('offset') : 0;
    getYtVideos($offset, playListId);
}

function showYTGrid($offset) {
    if (!$offset !== 'CAoQAA') {
        $w = getOptimalVideoTileW();
        $('#video-overview-pt' + $offset).unitegallery({
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
    }
    $('.load-more').hide();
    Cookies.remove('isLoading');
}
function getOptimalVideoTileW() {
    $w = $('#wrapper').width();
    $wind = $(window).width();
    if ($wind > 1000) {
        $w = $w / 3;
    } else if ($wind > 700) {
        $w = $w / 2;
    }
    return $w - 15;
}
