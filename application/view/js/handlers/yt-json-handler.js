function getYtVideos($offset, $playlistId) {
    $.get(
            'https://www.googleapis.com/youtube/v3/playlistItems',
            {
                part: 'snippet',
                playlistId: $playlistId,
                key: 'AIzaSyB1tatYXXg11UgkboD3O0seY51b5a6bFCY',
                maxResults: '10'
            }, function ($recieve) {      
        $html = createYtGridItems($recieve.items.snippet, $offset);
        $('#video-overview').append($html);
        showYTGrid($offset);
    }
    );
}


function createYtGridItems($recieve, $offset) {
    //show loader
    $html = '<div id="video-overview-pt' + $offset + '"';
    $html += ' class="video-overview" style="display:none;" data-offset="' + $offset + '">';
    $.each($recieve, function($id, $vid) {
        console.log($vid);
        $html += '<img data-type="youtube" src="'+$vid.thumbnalis.medium.url+'" ';
        $html +='data-image="'+$vid.thumbnalis.standard.url+'" ';
        $html +='data-descriptions="'+$vid.title+'" ';
        $html +='data-videoid="'+$vid.resourceId.videoId+'" style="display:none"';
        $html +='>';
    });
    $html += '</div>';
    return $html;
}

//< img alt = "Waimea cliff jump"
//        data - type = "youtube"  src = "https://i.ytimg.com/vi/sogCtOe8FFY/mqdefault.jpg"
//        data - image = "https://i.ytimg.com/vi/sogCtOe8FFY/sddefault.jpg"
//        data - description = "Waimea cliff jump description"
//        data - videoid = "sogCtOe8FFY" style = "display:none" >