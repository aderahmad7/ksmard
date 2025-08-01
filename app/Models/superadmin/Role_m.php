<?php

namespace App\Models\Superadmin;

use CodeIgniter\Model;

class Role_m extends Model
{
    protected $table = 'ksmard_t_role';
    protected $primaryKey = 'roleAccUsername';
    protected $allowedFields = ['roleAccUsername', 'roleRole', 'roleKodePKS', 'roleKodeDinas'];
    protected $useTimestamps = true;
    protected $createdField = 'roleCreateAt';
    protected $updatedField = 'roleUpdateAt';
}
