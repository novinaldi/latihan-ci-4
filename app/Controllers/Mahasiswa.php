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
            $data =  [
                'tampildata' => $this->mhs->findAll()
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


                $this->mhs->insert($simpandata);

                $msg = [
                    'sukses' => 'Data mahasiswa berhasil tersimpan'
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $nobp = $this->request->getVar('nobp');

            $row = $this->mhs->find($nobp);

            $data = [
                'nobp' => $row['nobp'],
                'nama' => $row['nama'],
                'tempat' => $row['tmplahir'],
                'tgl' => $row['tgllahir'],
                'jenkel' => $row['jenkel'],
            ];

            $msg = [
                'sukses' => view('mahasiswa/modaledit', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {

            $simpandata = [
                'nama' => $this->request->getVar('nama'),
                'tmplahir' => $this->request->getVar('tempat'),
                'tgllahir' => $this->request->getVar('tgl'),
                'jenkel' => $this->request->getVar('jenkel'),

            ];


            $nobp = $this->request->getVar('nobp');

            $this->mhs->update($nobp, $simpandata);

            $msg = [
                'sukses' => 'Data mahasiswa berhasil diupdate'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {
            $nobp = $this->request->getVar('nobp');

            // $mhs = new Modelmahasiswa;

            $this->mhs->delete($nobp);

            $msg = [
                'sukses' => "Mahasisw dengan nobp $nobp berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }
}