<?php
namespace App\Models\Pks;

use CodeIgniter\Model;

class Pemasaran_m extends Model
{
    protected $table = 'ksmard_t_pemasaran_pks';
    protected $primaryKey = 'psrKode';
    protected $allowedFields = [
        'psrKode',
        'psrUraian',
        'psrTbsKode',
        'psrIsEkspor',
        'psrTotal',
        'psrVolume',
        'psrKatpsrVolume',
        'psrIndkKode',
        'psrKomentar',
        'psrKatpsrKode'
    ];

    public function getRekap($periode)
    {
        return $this->table($this->table)
            ->select('SUM(CASE 
                        WHEN psrTbsKode = "cpo" and psrIsEkspor=1 
                        THEN ROUND(psrTotal/psrVolume,2)
                        ELSE 0 
                      END) AS cpo_ekspor,
                      SUM(CASE 
                        WHEN psrTbsKode = "cpo" and psrIsEkspor=0 
                        THEN ROUND(psrTotal/psrVolume,2) 
                        ELSE 0 
                      END) AS cpo_lokal,
                      SUM(CASE 
                        WHEN psrTbsKode = "inti" and psrIsEkspor=1 
                        THEN ROUND(psrTotal/psrVolume,2)
                        ELSE 0 
                      END) AS inti_ekspor,
                      SUM(CASE 
                        WHEN psrTbsKode = "inti" and psrIsEkspor=0 
                        THEN ROUND(psrTotal/psrVolume,2)
                        ELSE 0 
                      END) AS inti_lokal,
                      
                      SUM(CASE 
                        WHEN psrTbsKode = "cpo" and psrIsEkspor=1 
                        THEN psrTotal
                        ELSE 0 
                      END) AS cpo_ekspor_total,
                      SUM(CASE 
                        WHEN psrTbsKode = "cpo" and psrIsEkspor=0 
                        THEN psrTotal
                        ELSE 0 
                      END) AS cpo_lokal_total,
                      SUM(CASE 
                        WHEN psrTbsKode = "inti" and psrIsEkspor=1 
                        THEN psrTotal
                        ELSE 0 
                      END) AS inti_ekspor_total,
                      SUM(CASE 
                        WHEN psrTbsKode = "inti" and psrIsEkspor=0 
                        THEN psrTotal
                        ELSE 0 
                      END) AS inti_lokal_total')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_pemasaran_pks.psrIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getRowArray();
    }
}
?>