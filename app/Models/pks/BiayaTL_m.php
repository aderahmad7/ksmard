<?php
namespace App\Models\Pks;

use CodeIgniter\Model;

class BiayaTL_m extends Model
{
    protected $table = 'ksmard_t_biaya_tl_pks';
    protected $primaryKey = 'biaytlKode';
    protected $allowedFields = [
        'biaytlKode',
        'biaytlUraian',
        'katbiayNama',
        'biaytlTotal',
        'biaytlVolume',
        'biaytlKatbiayKode',
        'biaytlIndkKode',
    ];

    public function getRekap($periode)
    {
        return $this->table($this->table)
            ->select('SUM(biaytlTotal) AS total_biaya_tl,AVG(biaytlVolume) AS total_vol_tl')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_biaya_tl_pks.biaytlIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getRowArray();
    }
}
?>