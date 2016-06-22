function getHomeNewsfeed(setHomeListeners, dispNotif) {
    $url = $base + 'newsfeeds/get/all/6';
    $.get($url, function ($recieve) {
        $data = 'recieve';
        if ($recieve.toLowerCase().indexOf('internal-error') < 0 && $recieve.toLowerCase().indexOf('notice') < 0) {
            if ($recieve.toLowerCase().indexOf('found') > 0) {
                return;
            }
            try {
                $data = $.parseJSON($recieve);
                $html = '';
                $nav = '';
                $.each($data, function ($id, $newsfeed) {
                    $nav += createNav($id, $newsfeed);
                    $html += createNewsfeedItem($id, $newsfeed);
                });
                $('#newsfeed-nav .menu').append($nav);
                $('#newsfeed-items').append($html);
                setHomeListeners();
                setTimeout(function () {
                    $('body').removeClass('loading');
                    $('#home-loader').removeClass('page-loader');
                    repaint();
                    dispNotif();
                }, 500);
            } catch (e) {
                //handle error
                console.log('error: ' + e);
            }
        } else {
            console.log('\nno data found\n' + $recieve);
        }
    });
}

function createNewsfeedItem($id, $newsfeed) {
    $decoded = $('<li />').html($newsfeed['newsfeed_body']).text();
    $html = '<div class="newsfeed-item">';
    $html += '<img data-newsfeed-img="' + $newsfeed['newsfeed_img']['img_url'] + '" class="newsfeed-img" src="" alt="' + $newsfeed['newsfeed_img']['img_alt'] + '">';
    $html += '<div class="newsfeed-desc">';
    $html += '<h2>' + $newsfeed['newsfeed_subject'] + '</h2><ul>';
    $html += $decoded;
    $html += '</ul></div></div>';
    return $html;
}
function createNav($id, $newsfeed) {
    $class = $id === 0 ? 'active' : '';
    $nav = '<li class="' + $class + '">';
    $nav += '<a href="#">' + $newsfeed['newsfeed_subject'] + '</a>';
    $nav += '</li>';
    return $nav;
}