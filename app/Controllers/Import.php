<?php

namespace App\Controllers;

class Import extends BaseController
{
    public function index()
    {
        return view('viewimport');
    }

    function do()
    {
        $file_excel = $this->request->getFile('ff');

        $file_ekstensi = $file_excel->getClientExtension();

        if ('xls' == $file_ekstensi) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $reader->load($file_excel);

        $data = $spreadsheet->getActiveSheet()->toArray();

        $pesan = [];
        $error = [];
        foreach ($data as $x => $row) {
            if ($x == 0) {
                continue;
            }

            $nobp = $row[1];
            $nama = $row[2];

            $db = \Config\Database::connect();

            //cek dulu
            $ceknobp = $db->table('mahasiswa')->getWhere(['nobp' => $nobp])->getResult();
            if (count($ceknobp) > 0) {
                $error[] = "Nobp : <strong>$nobp</strong> sudah ada <br>";
            } else {
                $data = [
                    'nobp' => $nobp,
                    'nama' => $nama,
                    'mhsprodiid' => 1
                ];
                $db->table('mahasiswa')->insert($data);

                $pesan[] = "Data Nobp : <strong>$nobp</strong> berhasil disimpan<br>";
            }
        }

        foreach ($pesan as $a) {
            echo $a;
        }
        foreach ($error as $e) {
            echo $e;
        }
    }
}