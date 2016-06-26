function dispNotif() {
    $suc = Cookies.get('notifSucc');
    $err = Cookies.get('notifErr');
    $nfo = Cookies.get('notifNfo');
    if ($suc) {
        $suc = $suc.replace(/[+]/g, ' ');
        notifShowNow($suc, 'success');
        Cookies.remove('notifSucc');
    }
    if ($err) {
        $err = $err.replace(/[+]/g, ' ');
        notifShowNow($err, 'error');
        Cookies.remove('notifErr');
    }
    if($nfo) {
        $nfo = $nfo.replace(/[+]/g, ' ');
        notifShowNow($nfo,'info');
        Cookies.remove('notifNfo');
    }
}

function notifShowNow($txt, $type) {
    $.notify($txt, {position: 'right bottom', className: $type});
}