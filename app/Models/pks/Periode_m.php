<?php

namespace App\Models\Pks;

use CodeIgniter\Model;

class Periode_m extends Model
{
    protected $table = 'ksmard_t_indeks_k_pks';
    protected $primaryKey = 'indkKode';
    protected $allowedFields = ['indkKode', 'indkPeriodeBulan', 'indkPeriodeTahun', 'indkIndeksK', 'indkStatus', 'indkDinasKode', 'indkPksKode'];

    public function getTahunArr($pks)
    {
        $builder = $this->table($this->table );
        $builder->select('indkPeriodeTahun');
        $builder->distinct();
        $builder->where("indkPksKode",$pks);
        $builder->orderBy('indkPeriodeTahun', 'DESC');
        $query   = $builder->get();  // Produces: SELECT * FROM mytable
        $cb = [];
        foreach ($query->getResultArray() as $row => $val)
            $cb[$val["indkPeriodeTahun"]] = $val["indkPeriodeTahun"];

        return $cb; // gunakan getResultArray agar hasilnya array per row
    }
}
