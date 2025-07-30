<?php
namespace App\Models\Ref;

use CodeIgniter\Model;

class KategoriPemasaran_m extends Model
{
    protected $table = 'ksmard_r_kat_pemasaran_pks';
    protected $primaryKey = 'katpsrKode';
    protected $allowedFields = [
        'katpsrKode',
        'katpsrNama',
    ];

  
}
?>