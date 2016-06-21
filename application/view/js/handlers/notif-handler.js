function dispNotif() {
    $suc = Cookies.get('notifSucc');
    $err = Cookies.get('notifErr');
    if ($suc) {
        $.notify($suc, {position: 'right bottom', className: 'success'});
        Cookies.remove('notifSucc');
    }
    if ($err) {
        $.notify($err, {position: 'right bottom', className: 'error'});
        Cookies.remove('notifErr');
    }
}