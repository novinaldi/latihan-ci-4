<?php
function cekakses()
{
    $session = \Config\Services::session();
    if ($session->get('idlevel') == 1) {
        return true;
    } else {
        return redirect()->to('/login/index');
    }
}