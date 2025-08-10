<?php

namespace App\Models\Ref;

use CodeIgniter\Model;

class ProvinsiM extends Model
{
    protected $table            = 'ksmard_r_provinsi';
    protected $primaryKey       = 'provKode';
    protected $allowedFields    = ['provNamaLengkap','provNamaPendek','provIdSvg'];
}
