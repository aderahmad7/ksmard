<?php
namespace App\Models\Pks;

use CodeIgniter\Model;

class Produksi_m extends Model
{
    protected $table = 'ksmard_t_produksi_pks';
    protected $primaryKey = 'prodKode';
    protected $allowedFields = [
        'prodKode',
        'prodJenisProduksi',
        'prodVolume',
        'prodIndkKode',
    ];
}
?>