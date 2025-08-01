<?php
namespace App\Models\Pks;

use CodeIgniter\Model;

class Produksi_m extends Model
{
    protected $table = 'ksmard_t_produksi_pks';
    protected $primaryKey = 'prodKode';
    protected $allowedFields = [
        'prodKode',
        'prodJenisProduksi',
        'prodVolume',
        'prodIndkKode',
        'prodKatproKode',
        'prodKomentar',
    ];

    public function getRekap($periode)
    {
        return $this->table($this->table)
            ->select('SUM(prodVolume) AS volume')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_produksi_pks.prodIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getRowArray();
    }
}
?>