<?php

namespace App\Controllers;

use App\Models\Modelmahasiswa;

class Mahasiswa extends BaseController
{
    public function index()
    {
        $mhs = new Modelmahasiswa;
        $data =  [
            'tampildata' => $mhs->findAll()
        ];

        return view('mahasiswa/viewtampildata', $data);
    }
}