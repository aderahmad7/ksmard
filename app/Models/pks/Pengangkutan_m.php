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
        'angIndkKode',
    ];

    public function getRekap($periode)
    {
        return $this->table($this->table)
            ->select('SUM(CASE 
                        WHEN angTbsKode = "cpo" and angIsEkspor=1 
                        THEN ROUND(angTotal/angVolume,2)
                        ELSE 0 
                      END) AS cpo_ekspor,
                      SUM(CASE 
                        WHEN angTbsKode = "cpo" and angIsEkspor=0 
                        THEN ROUND(angTotal/angVolume,2) 
                        ELSE 0 
                      END) AS cpo_lokal,
                      SUM(CASE 
                        WHEN angTbsKode = "inti" and angIsEkspor=1 
                        THEN ROUND(angTotal/angVolume,2)
                        ELSE 0 
                      END) AS inti_ekspor,
                      SUM(CASE 
                        WHEN angTbsKode = "inti" and angIsEkspor=0 
                        THEN ROUND(angTotal/angVolume,2)
                        ELSE 0 
                      END) AS inti_lokal')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_pengangkutan_pks.angIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getRowArray();
    }
}
?>