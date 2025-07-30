<?php
namespace App\Models\Pks;

use CodeIgniter\Model;

class ProduksiHasil_m extends Model
{
    protected $table = 'ksmard_t_produksi_hasil_pks';
    protected $primaryKey = 'hasilKode';
    protected $allowedFields = [
        'hasilKode',
        'hasilJenisHasil',
        'hasilVolume',
        'hasilIndkKode',
    ];

    public function getRekap($periode)
    {
        return $this->table($this->table)
            ->select('SUM(CASE 
                        WHEN hasilJenisHasil = "cpo"
                        THEN ROUND(hasilVolume,2)
                        ELSE 0 
                      END) AS cpo,
                      SUM(CASE 
                        WHEN hasilJenisHasil = "inti"
                        THEN ROUND(hasilVolume,2)  
                        ELSE 0 
                      END) AS inti')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_produksi_hasil_pks.hasilIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getRowArray();
    }
}
?>