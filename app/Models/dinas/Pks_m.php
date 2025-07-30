<?php

namespace App\Models\Dinas;

use CodeIgniter\Model;

class Pks_m extends Model
{
    protected $table = 'ksmard_m_pks';
    protected $primaryKey = 'pksKode';
    protected $allowedFields = ['pksKode', 'pksNama', 'pksDinasKode'];
}
