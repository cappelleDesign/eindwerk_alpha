function getYtVideos($offset, $playlistId) {
    $url = 'https://www.googleapis.com/youtube/v3/playlistItems';
    $offsetVal = '';
    if ($offset == 'None') {
        $('.load-more').hide();
        Cookies.remove('isLoading');
        $('#no-mass').removeClass('hidden');
        return;
    } 
    $offsetVal = $offset ? $offset : '';
    $.get(
            $url,
            {
                part: 'snippet',
                playlistId: $playlistId,
                key: 'AIzaSyB1tatYXXg11UgkboD3O0seY51b5a6bFCY',
                maxResults: '9',
                pageToken: $offsetVal
            }, function ($recieve) {
        $offset = $recieve.nextPageToken;
        if (typeof $offset == 'undefined') {            
            $offset = 'None';
        }
        console.log($offset);
        $html = createYtGridItems($recieve.items, $offset);
        $('.video-container').append($html);
        showYTGrid($offset);
    }
    ).fail(function () {
        $('#no-mass').show();
    });
}


function createYtGridItems($recieve, $offset) {
    $('.load-more').show();
    $html = '<div id="video-overview-pt' + $offset + '"';
    $html += ' class="video-overview" style="display:none;" data-offset="' + $offset + '">';
    $.each($recieve, function ($id, $vid) {

        $vid = $vid.snippet;
        $html += '<img data-type="youtube" src="' + $vid.thumbnails.medium.url + '" ';
        $html += 'data-image="' + $vid.thumbnails.standard.url + '" ';
        $html += 'data-description="' + $vid.title + '" ';
        $html += 'data-videoid="' + $vid.resourceId.videoId + '" style="display:none"';
        $html += ' alt="' + $vid.title + '">';
    });
    $html += '</div>';
    return $html;
}

//< img alt = "Waimea cliff jump"
//        data - type = "youtube"  src = "https://i.ytimg.com/vi/sogCtOe8FFY/mqdefault.jpg"
//        data - image = "https://i.ytimg.com/vi/sogCtOe8FFY/sddefault.jpg"
//        data - description = "Waimea cliff jump description"
//        data - videoid = "sogCtOe8FFY" style = "display:none" >

//<img data-type="youtube" src="https://i.ytimg.com/vi/aAm5E9N6Rio/mqdefault.jpg" data-image="https://i.ytimg.com/vi/aAm5E9N6Rio/sddefault.jpg" data-description="Let's Play Zelda Breath of the Wild - Kinda Funny Plays E3 2016" data-videoid="aAm5E9N6Rio" style="display:none">