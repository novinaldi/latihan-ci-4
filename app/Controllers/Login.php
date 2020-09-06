<?php

namespace App\Controllers;

class Login extends BaseController
{

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        return view('login/index');
    }

    public function cekuser()
    {
        if ($this->request->isAJAX()) {
            $userid = $this->request->getVar('userid');
            $pass = $this->request->getVar('pass');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'userid' => [
                    'label' => 'ID User',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ],

                'pass' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong'
                    ]
                ]
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'userid' => $validation->getError('userid'),
                        'password' => $validation->getError('pass'),
                    ]
                ];
            } else {


                //cek user dulu ke database
                $query_cekuser = $this->db->query("SELECT * FROM users JOIN levels ON levelid=userlevelid WHERE userid='$userid'");

                $query_cekusermahasiswa = $this->db->query("SELECT * FROM mahasiswa JOIN levels ON levelid=mhslevelid WHERE nobp='$userid'");

                $result = $query_cekuser->getResult();
                $result_mhs = $query_cekusermahasiswa->getResult();

                if (count($result) > 0) {
                    // lanjutkan
                    $row = $query_cekuser->getRow();
                    $password_user = $row->userpass;

                    if (password_verify($pass, $password_user)) {
                        //buat session
                        $simpan_session = [
                            'login' => true,
                            'iduser' => $userid,
                            'namauser' => $row->usernama,
                            'idlevel' => $row->userlevelid,
                            'namalevel' => $row->levelnama
                        ];
                        $this->session->set($simpan_session);

                        $msg = [
                            'sukses' => [
                                'link' => site_url('layout/index')
                            ]
                        ];
                    } else {
                        $msg = [
                            'error' => [
                                'password' => 'Maaf password anda salah'
                            ]
                        ];
                    }
                } elseif (count($result_mhs) > 0) {
                    $row_mhs = $query_cekusermahasiswa->getRow();
                    $pass_mhs = $row_mhs->mhspass;

                    if (password_verify($pass, $pass_mhs)) {
                        $simpan_session = [
                            'login' => true,
                            'iduser' => $userid,
                            'namauser' => $row_mhs->nama,
                            'idlevel' => $row_mhs->mhslevelid,
                            'namalevel' => $row_mhs->levelnama
                        ];
                        $this->session->set($simpan_session);

                        $msg = [
                            'sukses' => [
                                'link' => site_url('layout/index')
                            ]
                        ];
                    } else {
                        $msg = [
                            'error' => [
                                'password' => 'Maaf password anda salah'
                            ]
                        ];
                    }
                } else {
                    $msg = [
                        'error' => [
                            'userid' => 'Maaf ID User tidak ditemukan'
                        ]
                    ];
                }
            }

            echo json_encode($msg);
        }
    }

    public function keluar()
    {
        $this->session->destroy();
        return redirect()->to('/login/index');
    }

    // function test()
    // {
    //     echo password_hash('123', PASSWORD_BCRYPT);
    // }
}