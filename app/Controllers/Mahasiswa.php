<?php

namespace App\Controllers;

use App\Models\Modelmahasiswa;
use App\Models\Modeldatamahasiswa;
use Config\Services;

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


    public function listdata()
    {
        $request = Services::request();
        $datamodel = new Modeldatamahasiswa($request);
        if ($request->getMethod(true) == 'POST') {
            $lists = $datamodel->get_datatables();
            $data = [];
            $no = $request->getPost("start");
            foreach ($lists as $list) {
                $no++;
                $row = [];

                $tomboledit = "<button type=\"button\" class=\"btn btn-info btn-sm\" onclick=\"edit('" . $list->nobp . "')\"><i class=\"fa fa-tags\"></i></button>";

                $tombolhapus = "<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"hapus('" . $list->nobp . "')\">
                <i class=\"fa fa-trash\"></i>
            </button>";

                $row[] = "<input type=\"checkbox\" name=\"nobp[]\" class=\"centangNobp\" value=\"$list->nobp\">";
                $row[] = $no;
                $row[] = $list->nobp;
                $row[] = $list->nama;
                $row[] = $list->tmplahir;
                $row[] = $list->tgllahir;
                $row[] = $list->jenkel;
                $row[] = $list->prodinama;
                $row[] = $tomboledit . " " . $tombolhapus;
                $data[] = $row;
            }
            $output = [
                "draw" => $request->getPost('draw'),
                "recordsTotal" => $datamodel->count_all(),
                "recordsFiltered" => $datamodel->count_filtered(),
                "data" => $data
            ];
            echo json_encode($output);
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



    public function formtambahbanyak()
    {
        if ($this->request->isAJAX()) {
            $msg = [
                'data' => view('mahasiswa/formtambahbanyak')
            ];

            echo json_encode($msg);
        }
    }

    public function simpandatabanyak()
    {
        if ($this->request->isAJAX()) {
            $nobp = $this->request->getVar('nobp');
            $nama = $this->request->getVar('nama');
            $tempat = $this->request->getVar('tempat');
            $tgl = $this->request->getVar('tgl');
            $jenkel = $this->request->getVar('jenkel');

            $jmldata = count($nobp);

            for ($i = 0; $i < $jmldata; $i++) {
                $this->mhs->insert([
                    'nobp' => $nobp[$i],
                    'nama' => $nama[$i],
                    'tmplahir' => $tempat[$i],
                    'tgllahir' => $tgl[$i],
                    'jenkel' => $jenkel[$i],
                ]);
            }

            $msg = [
                'sukses' => "$jmldata data mahasiswa berhasil tersimpan"
            ];

            echo json_encode($msg);
        }
    }

    public function hapusbanyak()
    {
        if ($this->request->isAJAX()) {
            $nobp = $this->request->getVar('nobp');

            $jmldata = count($nobp);

            for ($i = 0; $i < $jmldata; $i++) {
                $this->mhs->delete($nobp[$i]);
            }

            $msg = [
                'sukses' => "$jmldata data mahasiswa berhasil dihapus"
            ];

            echo json_encode($msg);
        }
    }
}