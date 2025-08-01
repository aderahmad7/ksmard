<?php
namespace App\Models;

use CodeIgniter\Model;

class IndeksKProvinsi_m extends Model
{
    protected $table = 'ksmard_t_indeks_k_provinsi';
    protected $primaryKey = 'kprovKode';
    protected $allowedFields = [
        'kprovKode',
        'kprovDinKode',
        'kprovPeriodeBulan',
        'kprovPeriodeTahun',
        'kprovIndeksK',
        'kprovIsPublish',
        'kprovTanggalPenetapan',
    ];

  

    
}
?>