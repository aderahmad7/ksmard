<?php
namespace App\Models\Pks;

use CodeIgniter\Model;

class Periode_m extends Model
{
    protected $table = 'ksmard_t_indeks_k_pks';
    protected $primaryKey = 'indkKode';
    protected $allowedFields = ['indkKode', 'indkPeriodeBulan', 'indkPeriodeTahun','indkIndeksK'];
}
?>