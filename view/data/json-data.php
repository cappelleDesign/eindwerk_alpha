<?php
if (!$_POST['jsonData']) {
    echo 'Error: No data recieved';
} else {
    $data = $_POST['jsonData'];
    if (!$data) {
        echo 'Error: Data could not be created correctly';
    } else {
        $jsonStr = json_encode($data);
        if (!$jsonStr) {
            echo 'Error: The transaction from data to json had an error';
        } else {
            echo $jsonStr;
        }
    }
}
