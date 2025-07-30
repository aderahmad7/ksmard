<?php
namespace App\Models\Ref;

use CodeIgniter\Model;

class KategoriBiayaTL_m extends Model
{
    protected $table = 'ksmard_r_kat_biayatl_pks';
    protected $primaryKey = 'katbiayKode';
    protected $allowedFields = [
        'katbiayKode',
        'katbiayNama',
    ];  
}

?>