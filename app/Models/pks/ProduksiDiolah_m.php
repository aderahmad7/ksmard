<?php

namespace App\Models\Pks;

use CodeIgniter\Model;

class ProduksiDiolah_m extends Model
{
    protected $table = 'ksmard_t_produksi_diolah_pks';
    protected $primaryKey = 'olahKode';
    protected $allowedFields = ['olahKode', 'olahVolume', 'olahIndkKode','olahKomentar'];

    public function getRekap($periode)
    {
        return $this->table($this->table)
            ->select('SUM(olahVolume) AS volume')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_produksi_diolah_pks.olahIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getRowArray();
    }
}
