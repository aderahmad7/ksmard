<?php
namespace App\Models\Ref;

use CodeIgniter\Model;

class KategoriPengolahan_m extends Model
{
    protected $table = 'ksmard_r_kat_pengolahan_pks';
    protected $primaryKey = 'katolahKode';
    protected $allowedFields = [
        'katolahKode',
        'katolahNama',
        'katolahSubNama',
    ];

  
}
?>