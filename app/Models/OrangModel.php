<?php

namespace App\Models;

use CodeIgniter\Model;

class OrangModel extends Model
{
    protected $table = "orang";
    protected $useTimeStamps = true;
    //memberi field yg bisa diisi manual
    protected $allowedFields = ['nama', 'alamat'];

}
