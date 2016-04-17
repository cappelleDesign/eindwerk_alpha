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
    if ($size in $sizeArr) {
        $src = getImgSrc($sizeArr[$size], $path, $img, false);
        setMainSliderPic($el, $src);
        $srcSide = getImgSrc($sizeArr[$size], $path, $img, true);
        setSideSliderPic($el, $srcSide);
    }
}

function setNewsfeedPic($el){
    $newsfeedItem = $($el);
    $path = 'newsfeeditems';
    $img = $newsfeedItem.data('newsfeed-img');
    
    $sizeArr = getNewsfeedSizes();
    $size = getCurrentSize();
    if($size in $sizeArr) {
        $src = getImgSrc($sizeArr[$size], $path, $img, false);        
        $newsfeedItem.prop('src', $src);
    }
}

function getCarouselSizes() {
    $sizes = {
        'xl': {
            'w': '1100',
            'h': '400',
            'sw': '152',
            'sh': '402'
        },
        'l': {
            'w': '800',
            'h': '400',
            'sw': '102',
            'sh': '402'
        },
        'm': {
            'w': '',
            'h': '',
            'sw': '',
            'sh': ''
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

