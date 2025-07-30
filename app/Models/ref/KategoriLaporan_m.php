<?php

namespace App\Models\Ref;

use CodeIgniter\Model;

class KategoriLaporan_m extends Model
{
    protected $table = 'ksmard_r_kat_laporan';
    protected $primaryKey = 'katlapKode';
    protected $allowedFields = [
        'katlapKode',
        'katlapNama',
    ];
}
