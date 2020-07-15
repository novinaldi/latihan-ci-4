<?php

namespace App\Controllers;

use App\Models\Modelmahasiswa;

class Mahasiswa extends BaseController
{
    public function index()
    {


        return view('mahasiswa/viewtampildata');
    }

    public function ambildata()
    {
        if ($this->request->isAJAX()) {
            $mhs = new Modelmahasiswa;
            $data =  [
                'tampildata' => $mhs->findAll()
            ];

            $msg = [
                'data' => view('mahasiswa/datamahasiswa', $data)
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('mahasiswa/modaltambah')
            ];

            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nobp' => [
                    'label' => 'Nomor BP',
                    'rules' => 'required|is_unique[mahasiswa.nobp]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh ada yang sama, silahkan coba yang lain'
                    ]
                ],
                'nama' => [
                    'label' => 'Nama Mahasiswa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);

            if (!$valid) {

                $msg = [
                    'error' => [
                        'nobp' => $validation->getError('nobp'),
                        'nama' => $validation->getError('nama')
                    ]
                ];
            } else {
                $simpandata = [
                    'nobp' => $this->request->getVar('nobp'),
                    'nama' => $this->request->getVar('nama'),
                    'tmplahir' => $this->request->getVar('tempat'),
                    'tgllahir' => $this->request->getVar('tgl'),
                    'jenkel' => $this->request->getVar('jenkel'),

                ];

                $mhs = new Modelmahasiswa;

                $mhs->insert($simpandata);

                $msg = [
                    'sukses' => 'Data mahasiswa berhasil tersimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
}