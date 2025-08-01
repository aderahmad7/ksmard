<?php
namespace App\Models\Pks;

use CodeIgniter\Model;

class Pengolahan_m extends Model
{
    protected $table = 'ksmard_t_pengolahan_pks';
    protected $primaryKey = 'olahKode';
    protected $allowedFields = [
        'olahKode',
        'olahUraian',
        'olahKatolahKode',
        'olahTotal',
        'olahIndkKode',
        'olahKomentar',
    ];

    public function getRekap($periode)
    {
        return $this->table($this->table)
            ->select('SUM(olahTotal) AS total_pengolahan')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_pengolahan_pks.olahIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getRowArray();
    }
}
?>