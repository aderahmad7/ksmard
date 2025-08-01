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
        'jualNoDokumen',
        'jualPembeli',
        'jualFile',
        'jualFileTipe',
        'jualTanggal',
        'jualKomentar',
        'jualIndkKode',
    ];

    public function getRekap($periode)
    {
        return $this->table($this->table)
            ->select('SUM(CASE 
                        WHEN jualTbsKode = "cpo" and jualIsEkspor=1 
                        THEN jualTotal
                        ELSE 0 
                      END) AS cpo_ekspor,
                      SUM(CASE 
                        WHEN jualTbsKode = "cpo" and jualIsEkspor=1 
                        THEN jualVolume
                        ELSE 0 
                      END) AS cpo_ekspor_vol,
                      SUM(CASE 
                        WHEN jualTbsKode = "cpo" and jualIsEkspor=0 
                        THEN jualTotal
                        ELSE 0 
                      END) AS cpo_lokal,
                      SUM(CASE 
                        WHEN jualTbsKode = "cpo" and jualIsEkspor=0
                        THEN jualVolume
                        ELSE 0 
                      END) AS cpo_lokal_vol,
                      SUM(CASE 
                        WHEN jualTbsKode = "inti" and jualIsEkspor=1 
                        THEN jualTotal
                        ELSE 0 
                      END) AS inti_ekspor,
                      SUM(CASE 
                        WHEN jualTbsKode = "inti" and jualIsEkspor=1 
                        THEN jualVolume
                        ELSE 0 
                      END) AS inti_ekspor_vol,
                      SUM(CASE 
                        WHEN jualTbsKode = "inti" and jualIsEkspor=0 
                        THEN jualTotal
                        ELSE 0 
                      END) AS inti_lokal,
                      SUM(CASE 
                        WHEN jualTbsKode = "inti" and jualIsEkspor=0 
                        THEN jualVolume
                        ELSE 0 
                      END) AS inti_lokal_vol')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_penjualan_pks.jualIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getRowArray();
    }

    public function getProduksiVsPenjualan($periode)
    {
        return $this->table($this->table)
            ->select('SUM(CASE 
                        WHEN jualTbsKode = "cpo" and jualIsEkspor=1 
                        THEN jualTotal
                        ELSE 0 
                      END) AS cpo_ekspor,
                      SUM(CASE 
                        WHEN jualTbsKode = "cpo" and jualIsEkspor=1 
                        THEN jualVolume
                        ELSE 0 
                      END) AS cpo_ekspor_vol,
                      SUM(CASE 
                        WHEN jualTbsKode = "cpo" and jualIsEkspor=0 
                        THEN jualTotal
                        ELSE 0 
                      END) AS cpo_lokal,
                      SUM(CASE 
                        WHEN jualTbsKode = "cpo" and jualIsEkspor=0
                        THEN jualVolume
                        ELSE 0 
                      END) AS cpo_lokal_vol,
                      SUM(CASE 
                        WHEN jualTbsKode = "inti" and jualIsEkspor=1 
                        THEN jualTotal
                        ELSE 0 
                      END) AS inti_ekspor,
                      SUM(CASE 
                        WHEN jualTbsKode = "inti" and jualIsEkspor=1 
                        THEN jualVolume
                        ELSE 0 
                      END) AS inti_ekspor_vol,
                      SUM(CASE 
                        WHEN jualTbsKode = "inti" and jualIsEkspor=0 
                        THEN jualTotal
                        ELSE 0 
                      END) AS inti_lokal,
                      SUM(CASE 
                        WHEN jualTbsKode = "inti" and jualIsEkspor=0 
                        THEN jualVolume
                        ELSE 0 
                      END) AS inti_lokal_vol')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_penjualan_pks.jualIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getRowArray();
    }
}
?>