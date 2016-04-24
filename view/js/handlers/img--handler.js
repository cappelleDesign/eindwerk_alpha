var $sliderPicsArr = false;
var $srcOg = 'view/phpscripts/image.php/parImg?width=parW&AMP;height=parH&AMP;cropratio=parCrop&AMP;image=/' + $viewRoot + '/images/par-img-path';

function setSliderPics() {
    $sliderItems = $('.slider-item');
    $.each($sliderItems, function ($i, $el) {
        setSliderPic($el);
    });
}

function setNewsfeedPics() {
    $newsfeedItems = $('.newsfeed-img');
    $.each($newsfeedItems, function ($i, $el) {
        setNewsfeedPic($el);
    });
}

function setSliderPic($el) {
    $sliderItem = $($el);
    $path = $sliderItem.data('img-path');
    $img = $sliderItem.data('img-url');

    $sizeArr = getCarouselSizes();
    $size = getCurrentSize();
    if($size === 'xs') {
        $size = 's';
    }
    if ($size === 'm') {
        if ($sliderItem.hasClass('primary-slide')) {
            $size += '-pri';
        } else {
            $size += '-sec';
        }
    }
    if ($size === 's') {
        $cw = $(document).width();
        $sizeArr[$size]['w'] = $cw;
    }
    if ($size in $sizeArr) {
        $src = getImgSrc($sizeArr[$size], $path, $img, false);
        setMainSliderPic($el, $src);
        $srcSide = getImgSrc($sizeArr[$size], $path, $img, true);
        setSideSliderPic($el, $srcSide);
    }
}

function setNewsfeedPic($el) {
    $newsfeedItem = $($el);
    $path = 'newsfeeditems';
    $img = $newsfeedItem.data('newsfeed-img');
    $cw = $(document).width();
    $sizeArr = getNewsfeedSizes();
    $size = getCurrentSize();
    if ($size === 's') {
        $sizeArr[$size]['w'] = Math.round($cw * 0.3);
        $sizeArr[$size]['h'] = Math.round($cw * 0.3);
    }
    if ($size === 'xs') {
        $sizeArr[$size]['w'] = $cw;
        $sizeArr[$size]['h'] = Math.round($cw * 0.3);
    }
    if ($size in $sizeArr) {
        $src = getImgSrc($sizeArr[$size], $path, $img, false);
        $newsfeedItem.prop('src', $src);
    }
}

function getCarouselSizes() {
    $sizes = {
        'xl': {
            'w': '1100',
            'h': '400',
            'sw': '150',
            'sh': '400'
        },
        'l': {
            'w': '800',
            'h': '400',
            'sw': '100',
            'sh': '400'
        },
        'm-pri': {
            'w': '800',
            'h': '300'
        },
        'm-sec': {
            'w': '399',
            'h': '300'
        },
        's': {
            'w': '',
            'h': '300'
        }
    };
    return $sizes;
}

function getNewsfeedSizes() {
    $sizes = {
        'xl': {
            'w': '800',
            'h': '320'
        },
        'l': {
            'w': '571',
            'h': '320'
        },
        'm': {
            'w': '400',
            'h': '350'
        },
        's': {
            'w': '',
            'h': '200'
        },
        'xs': {
            'w': '',
            'h': ''
        }
    };
    return $sizes;
}

function getImgSrc($sizeArr, $imgPath, $img, $isSide) {
    $w = $sizeArr['w'];
    $h = $sizeArr['h'];
    if ($isSide) {
        $w = $sizeArr['sw'];
        $h = $sizeArr['sh'];
    }
    $fullPath = $imgPath + '/' + $img;
    $crop = $w + ':' + $h;

    $src = $srcOg.replace('parImg', $img);
    $src = $src.replace('parW', $w);
    $src = $src.replace('parH', $h);
    $src = $src.replace('parCrop', $crop);
    $src = $src.replace('par-img-path', $fullPath);
    $src = $src.replace(/&AMP;/g, '&');
    return $src;
}

function getCurrentSize() {
    $w = $(document).width();
    if($w <= 570){
        return 'xs';
    }
    if ($w <= 810) {
        return 's';
    }
    if ($w <= 1040) {
        return 'm';
    }
    if ($w <= 1500) {
        return 'l';
    }
    return 'xl';

}
function setMainSliderPic($el, $src) {
    $($el).children('.jsImg').prop('src', $src);
}

function setSideSliderPic($el, $src) {
    $($el).data('img-src', $src);
}

