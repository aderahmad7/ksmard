<?php

namespace App\Models\Superadmin;

use CodeIgniter\Model;

class Dinas_m extends Model
{
    protected $table = 'ksmard_m_dinas';
    protected $primaryKey = 'dinKode';
    protected $allowedFields = ['dinKode', 'dinNama', 'dinProvinsi'];
}
