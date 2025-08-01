<?php
namespace App\Models\Pks;

use CodeIgniter\Model;

class Dinas_setting_m extends Model
{
    protected $table = 'ksmard_r_dinas_setting';
    protected $primaryKey = 'dinsetKode';
    protected $allowedFields = [
        'dinsetKode',
        'dinsetDinKode',
        'dinsetPersenBotl'
    ];

    
}
?>