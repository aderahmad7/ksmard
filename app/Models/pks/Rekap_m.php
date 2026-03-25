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

    public function getDataRekap($periode)
    {
        return $this->table($this->table)
            ->select('*')
            ->join('ksmard_r_kat_laporan', 'ksmard_r_kat_laporan.katlapKode = ksmard_t_rekap.rekapLapKode')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_rekap.rekapIndkKode')
            ->join('ksmard_t_komentar', 'ksmard_t_komentar.kmtLapKode = ksmard_r_kat_laporan.katlapKode and ksmard_t_komentar.kmtIndkKode = ksmard_t_rekap.rekapIndkKode','left')
            ->where('ksmard_t_indeks_k_pks.indkKode', $periode)
            ->get()
            ->getResultArray();
    }
    public function getDataFob($dinas,$bulan,$tahun)
    {
        return $this->table($this->table)
            ->select('ksmard_t_indeks_k_pks.indkPksKode, ksmard_t_rekap.*')
            ->join('ksmard_r_kat_laporan', 'ksmard_r_kat_laporan.katlapKode = ksmard_t_rekap.rekapLapKode')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_rekap.rekapIndkKode')
            ->join('ksmard_t_komentar', 'ksmard_t_komentar.kmtLapKode = ksmard_r_kat_laporan.katlapKode and ksmard_t_komentar.kmtIndkKode = ksmard_t_rekap.rekapIndkKode','left')
            ->where('ksmard_t_indeks_k_pks.indkDinasKode', $dinas)
            ->where('ksmard_t_indeks_k_pks.indkPeriodeBulan', $bulan)
            ->where('ksmard_t_indeks_k_pks.indkPeriodeTahun', $tahun)
            ->where('ksmard_r_kat_laporan.katlapKode', 1)
            ->get()
            ->getResultArray();
    }


    
}
?>