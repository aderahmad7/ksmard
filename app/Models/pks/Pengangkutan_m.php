<?php
namespace App\Models\Pks;

use CodeIgniter\Model;

class Pengangkutan_m extends Model
{
    protected $table = 'ksmard_t_pengangkutan_pks';
    protected $primaryKey = 'angKode';
    protected $allowedFields = [
        'angKode',
        'angUraian',
        'angTbsKode',
        'angIsEkspor',
        'angTotal',
        'angVolume',
        'angKomentar',
        'angIndkKode',
    ];

    public function getRekap($periode)
    {
        return $this->table($this->table)
            ->select('SUM(CASE 
                        WHEN angTbsKode = "cpo" and angIsEkspor=1 
                        THEN angTotal
                        ELSE 0 
                      END) AS cpo_ekspor_total,
                      SUM(CASE 
                        WHEN angTbsKode = "cpo" and angIsEkspor=0 
                        THEN angTotal
                        ELSE 0 
                      END) AS cpo_lokal_total,
                      SUM(CASE 
                        WHEN angTbsKode = "inti" and angIsEkspor=1 
                        THEN angTotal
                        ELSE 0 
                      END) AS inti_ekspor_total,
                      SUM(CASE 
                        WHEN angTbsKode = "inti" and angIsEkspor=0 
                        THEN angTotal
                        ELSE 0 
                      END) AS inti_lokal_total,

                      SUM(CASE 
                        WHEN angTbsKode = "cpo" and angIsEkspor=1 
                        THEN angVolume
                        ELSE 0 
                      END) AS cpo_ekspor_vol,
                      SUM(CASE 
                        WHEN angTbsKode = "cpo" and angIsEkspor=0 
                        THEN angVolume
                        ELSE 0 
                      END) AS cpo_lokal_vol,
                      SUM(CASE 
                        WHEN angTbsKode = "inti" and angIsEkspor=1 
                        THEN angVolume
                        ELSE 0 
                      END) AS inti_ekspor_vol,
                      SUM(CASE 
                        WHEN angTbsKode = "inti" and angIsEkspor=0 
                        THEN angVolume
                        ELSE 0 
                      END) AS inti_lokal_vol')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_pengangkutan_pks.angIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getRowArray();
    }
}
?>