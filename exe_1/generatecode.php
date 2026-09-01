<?php
date_default_timezone_set('Asia/Kuala_Lumpur');

function generateUniqueCode()
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
    $code = '';

    for ($i = 0; $i < 6; $i++) {
        $code .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return date('YmdHis') . "_" . $code;
}
?>
