<?php
namespace App\Models\Pks;

use CodeIgniter\Model;

class Penyusutan_m extends Model
{
    protected $table = 'ksmard_t_penyusutan_pks';
    protected $primaryKey = 'usutKode';
    protected $allowedFields = [
        'usutKode',
        'usutUraian',
        'usutTotal',
        'usutKatusutKode',
        'usutIndkKode',
    ];

    public function getRekap($periode)
    {
        return $this->table($this->table)
            ->select('SUM(usutTotal) AS total_penyusutan')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_penyusutan_pks.usutIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getRowArray();
    }
}
?>