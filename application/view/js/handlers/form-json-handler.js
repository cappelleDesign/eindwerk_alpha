$(init);

function init() {

}

function sendForm($url, $postVals) {
    $url = $base + '/' + $url;
    $data = 'No data';
    $.post($url, $postVals, function ($recieve) {
        if ($recieve.toLowerCase().indexOf('internal-error') < 0 && $recieve.toLowerCase().indexOf('notice') < 0) {
            if ($recieve.toLowerCase().indexOf('success') >= 0) {
               Cookies.set('notifSucc', 'Email send successfull!');
               window.location.replace('home');
            } else {
                //handle server side validation
            }
        }
    });
}