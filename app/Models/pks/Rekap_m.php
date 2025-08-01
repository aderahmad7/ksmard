<?php
namespace App\Models\Pks;

use CodeIgniter\Model;

class Rekap_m extends Model
{
    protected $table = 'ksmard_t_rekap';
    protected $primaryKey = 'rekapKode';
    protected $allowedFields = [
        'rekapKode',
        'rekapIndkKode',
        'rekapLapKode',
        'rekapCpoEkspor',
        'rekapCpoLokal',
        'rekapKernelLokal',
        'rekapKernelEkspor',
        'rekapTbs',
    ];

    public function getDashboardRekap($tahun,$dinas,$pks)
    {
        $builder = $this->db->query("
            SELECT 
                b.bulan AS indkPeriodeBulan,
                k.indkIndeksK
            FROM (
                SELECT 1 AS bulan UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL 
                SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL 
                SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL 
                SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12
            ) AS b
            LEFT JOIN ksmard_t_indeks_k_pks k 
                ON k.indkPeriodeBulan = b.bulan 
                AND k.indkPeriodeTahun = ? 
                AND k.indkDinasKode = ? 
                AND k.indkPksKode = ? 
                AND k.indkStatus = 'divalidasi'
            ORDER BY b.bulan
        ", [$tahun,$dinas,$pks]);

        return $builder->getResultArray(); // gunakan getResultArray agar hasilnya array per row
    }


    
}
?>