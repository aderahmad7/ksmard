<?php
namespace App\Models;

use CodeIgniter\Model;

class IndeksKProvinsi_m extends Model
{
    protected $table = 'ksmard_t_indeks_k_provinsi';
    protected $primaryKey = 'kprovKode';
    protected $allowedFields = [
        'kprovKode',
        'kprovDinKode',
        'kprovPeriodeBulan',
        'kprovPeriodeTahun',
        'kprovIndeksK',
        'kprovIsPublish',
        'kprovTanggalPenetapan',
    ];

    public function getTahunArr($pks)
    {
        $builder = $this->table($this->table);
        $builder->select('kprovPeriodeTahun');
        $builder->distinct();
        $builder->where("kprovDinKode",$pks);
        $builder->orderBy('kprovPeriodeTahun', 'DESC');
        $query   = $builder->get();  // Produces: SELECT * FROM mytable
        $cb = [];
        foreach ($query->getResultArray() as $row => $val)
            $cb[$val["kprovPeriodeTahun"]] = $val["kprovPeriodeTahun"];

        return $cb; // gunakan getResultArray agar hasilnya array per row
    }

    


  

    
}
?>