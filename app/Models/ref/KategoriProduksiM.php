<?php

namespace App\Models\Ref;

use CodeIgniter\Model;

class KategoriProduksiM extends Model
{
    protected $table            = 'ksmard_r_kat_produksi';
    protected $primaryKey       = 'katproKode';
    protected $allowedFields    = ['katproNama'];
}
