<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dosen extends Controller
{
    public function __construct()
    {
        $this->session = \Config\Services::session();

        if (!$this->session->get('idlevel') == 1) {
            return redirect()->to('/login/index');
        }
    }
    public function index()
    {
        if ($this->session->get('idlevel') == 1) {
            echo 'ini adalah  dosen index';
        } else {
            return redirect()->to('/login/index');
        }
    }
}