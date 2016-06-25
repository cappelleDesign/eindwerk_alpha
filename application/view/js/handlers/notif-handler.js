function dispNotif() {
    $suc = Cookies.get('notifSucc');
    $err = Cookies.get('notifErr');
    if ($suc) {
        $suc = $suc.replace(/[+]/g, ' ');
        notifShowNow($suc, 'success');
        Cookies.remove('notifSucc');
    }
    if ($err) {
        notifShowNow($err, 'error');
        Cookies.remove('notifErr');
    }
}

function notifShowNow($txt, $type) {
    $.notify($txt, {position: 'right bottom', className: $type});
}