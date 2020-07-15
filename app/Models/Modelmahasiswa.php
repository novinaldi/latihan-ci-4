<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelmahasiswa extends Model
{
    protected $table      = 'mahasiswa';
    protected $primaryKey = 'nobp';

    protected $allowedFields = ['nobp', 'nama', 'tmplahir', 'tgllahir', 'jenkel'];
}