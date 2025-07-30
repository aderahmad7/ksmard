<?php
namespace App\Models\Ref;

use CodeIgniter\Model;

class KategoriPenyusutan_m extends Model
{
    protected $table = 'ksmard_r_kat_penyusutan_pks';
    protected $primaryKey = 'katusutKode';
    protected $allowedFields = [
        'katusutKode',
        'katusutNama',
    ];

  
}
?>