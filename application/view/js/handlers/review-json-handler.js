function getHomeReviews(getHomeNewsfeedsIni, setHomeListeners, dispNotif) {
    $url = $base + '/reviews/get/all/3/created/desc/0';
    $.get($url, function ($recieve) {        
        $data = 'recieve';
        if ($recieve.toLowerCase().indexOf('internal-error') < 0 && $recieve.toLowerCase().indexOf('notice') < 0) {
            if ($recieve.toLowerCase().indexOf('found') > 0){
                console.log($recieve);
                return;
            }
            try {
                $data = $.parseJSON($recieve);
                $html = '';
                $.each($data, function ($id, $review) {
                    $html += createSliderItem($id, $review);
                });
                $('#inf-slider').html($html);
                $('.score').knob({
                    'min': 0,
                    'max': 10,
                    'width': 50,
                    'height': 50,
                    'font': 'Sans-serif'
                });  
                getHomeNewsfeedsIni(setHomeListeners,dispNotif);
            } catch (e) {
                //handle error
                console.log('error: ' + e);
            }
        } else {
            console.log('\nno data found\n' + $recieve);
        }
    });
}
function createSliderItem($id, $review) {
    $destin = $base + 'reviews/detailed/' + $review['review_id'];
    $class = $id === 0 ? 'primary-slide' : 'secondary-slide';
    $path = createImgPath($review);
    $img = $review['review_header_img']['img_url'];    
    $sliderItem = '<div class="slider-item ' + $class + '"'
            + ' data-img-path="games/' + $path + '"'
            + ' data-img-url="' + $img + '">'
            + ' <div class="slider-desc">'
            + ' <div class="mobile-center">'
            + ' <p>' + $review['review_title'] + '</p>'
            + ' <div class="stars">'
            + ' <input type="text" class="score" data-readOnly="true"'
            + ' value="' + $review['review_score'] + '"'
            + ' data-fgColor="#ef4123" data-bgColor="#231f20">'
            + ' </div></div></div>'
            + ' <img class="jsImg" src="" alt="' + $review['review_header_img']['img_alt'] + '">'
            + ' <div class="slider-more">'
            + ' <a href="' + $destin + '" class="btn btn-default">Read more</a>'
            + ' </div></div>';
    return $sliderItem;
}
function createImgPath($review) {
    $name = cleanPath($review['review_game']['game_name']);
    return $name;
}