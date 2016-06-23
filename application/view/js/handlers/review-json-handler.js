function createImgPath($review) {
    $name = cleanPath($review['review_game']['game_name']);
    return $name;
}


function getReviewsMore($offset) {
    $offCalc = '';
    if (typeof $offset !== 'undefined' && !isNaN($offset) && $offset > 0) {
        $offCalc = ($offset * 9);
        $offset++;
    } else {
        $offset = 1;
    }
    $url = $base + 'reviews/get/all/9/created/desc/0/' + $offCalc;
    $html = '';
    $.get($url, function ($recieve) {
        if ($recieve.toLowerCase().indexOf('internal-error') < 0 && $recieve.toLowerCase().indexOf('notice') < 0) {
            if ($recieve.toLowerCase().indexOf('found') > 0) {
                $('#no-mass').removeClass('hidden');
                $('#review-more-load').hide();
                return;
            } else {
                $html = createRevOverview($recieve, $offset);
                $('#reviews-content').append($html);
                pictureMode($offset, getOptimalWidth());
            }
        }

    });
}

function createRevOverview($recieve, $offset) {
    $('#review-more-load').show();
    $html = '<div id="reviews-overview-pt' + $offset + '"';
    $html += ' class="rev-overview" style="display:none;" data-offset="' + $offset + '">';
    $data = $.parseJSON($recieve);
    $.each($data, function ($id, $review) {
        $imgUrl = $imgRoot + 'games/' + createImgPath($review) + '/' + $review['review_header_img']['img_url']
        $html += '<a href="reviews/detailed/' + $review['review_id'] + '" data-score="' + $review['review_score'] + '">';
        $html += '<img ';
        $html += ' src="' + $imgUrl + '"';
        $html += ' alt="' + $review['review_header_img']['img_alt'] + '"';
        $html += ' data-image="' + $imgUrl + '"';
        $html += ' data-description ="' + $review['review_title'] + ' <span> [' + $review['review_score'] + '/10 ] </span>" >';
        $html += '</a>';
    });
    $html += '</div>';
    return $html;
}

//< div id = "reviews-gallery-pt1" class = "rev-overview" style = "display: none;" data - offset = "1" >
//        < a href = "reviews/detailed/1" data - score = "8" >
//        < img
//        src = "<?php echo $imgRoot ?>Fallout_4/Fallout_4.png"
//        alt = "Fallout 4"
//data - image = "<?php echo $imgRoot ?>Fallout_4/Fallout_4.png"
//        data - description = "Fallout 4 <span class='scores'> [ 8/10 ] </span>" >
//        < /a>

