<?php
namespace App\Models\Pks;

use CodeIgniter\Model;

class Pajak_m extends Model
{
    protected $table = 'ksmard_t_pajak_pks';
    protected $primaryKey = 'pjkKode';
    protected $allowedFields = [
        'pjkKode',
        'pjkUraian',
        'pjkTbsKode',
        'pjkIsEkspor',
        'pjkTotal',
        'pjkVolume',
        'pjkIndkKode',
        'pjkKomentar',
    ];

    public function getRekap($periode)
    {
        return $this->table($this->table)
            ->select('SUM(CASE 
                        WHEN pjkTbsKode = "cpo" and pjkIsEkspor=1 
                        THEN pjkTotal
                        ELSE 0 
                      END) AS cpo_ekspor_total,
                      SUM(CASE 
                        WHEN pjkTbsKode = "cpo" and pjkIsEkspor=0 
                        THEN pjkTotal
                        ELSE 0 
                      END) AS cpo_lokal_total,
                      SUM(CASE 
                        WHEN pjkTbsKode = "inti" and pjkIsEkspor=1 
                        THEN pjkTotal
                        ELSE 0 
                      END) AS inti_ekspor_total,
                      SUM(CASE 
                        WHEN pjkTbsKode = "inti" and pjkIsEkspor=0 
                        THEN pjkTotal
                        ELSE 0 
                      END) AS inti_lokal_total,

                      SUM(CASE 
                        WHEN pjkTbsKode = "cpo" and pjkIsEkspor=1 
                        THEN pjkVolume
                        ELSE 0 
                      END) AS cpo_ekspor_vol,
                      SUM(CASE 
                        WHEN pjkTbsKode = "cpo" and pjkIsEkspor=0 
                        THEN pjkVolume
                        ELSE 0 
                      END) AS cpo_lokal_vol,
                      SUM(CASE 
                        WHEN pjkTbsKode = "inti" and pjkIsEkspor=1 
                        THEN pjkVolume
                        ELSE 0 
                      END) AS inti_ekspor_vol,
                      SUM(CASE 
                        WHEN pjkTbsKode = "inti" and pjkIsEkspor=0 
                        THEN pjkVolume
                        ELSE 0 
                      END) AS inti_lokal_vol')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_pajak_pks.pjkIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getRowArray();
    }
}
?>