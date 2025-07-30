<?php
namespace App\Models\Pks;

use CodeIgniter\Model;

class Penjualan_m extends Model
{
    protected $table = 'ksmard_t_penjualan_pks';
    protected $primaryKey = 'jualKode';
    protected $allowedFields = [
        'jualKode',
        'jualUraian',
        'jualTbsKode',
        'jualIsEkspor',
        'jualVolume',
        'jualHarga',
        'jualTotal',
        'jualNoKontrak',
        'jualPembeli',
        'jualIndkKode',
    ];

    public function getRekap($periode)
    {
        return $this->table($this->table)
            ->select('SUM(CASE 
                        WHEN jualTbsKode = "cpo" and jualIsEkspor=1 
                        THEN ROUND(jualTotal/jualVolume,2)
                        ELSE 0 
                      END) AS cpo_ekspor,
                      SUM(CASE 
                        WHEN jualTbsKode = "cpo" and jualIsEkspor=0 
                        THEN ROUND(jualTotal/jualVolume,2)  
                        ELSE 0 
                      END) AS cpo_lokal,
                      SUM(CASE 
                        WHEN jualTbsKode = "inti" and jualIsEkspor=1 
                        THEN ROUND(jualTotal/jualVolume,2)
                        ELSE 0 
                      END) AS inti_ekspor,
                      SUM(CASE 
                        WHEN jualTbsKode = "inti" and jualIsEkspor=0 
                        THEN ROUND(jualTotal/jualVolume,2)  
                        ELSE 0 
                      END) AS inti_lokal')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_penjualan_pks.jualIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getRowArray();
    }
}
?>