<?php

namespace App\Models;

use CodeIgniter\Model;

class Komentar_m extends Model
{
    protected $table = 'ksmard_t_komentar';
    protected $primaryKey = 'kmtKode';
    protected $allowedFields = ['kmtKode', 'kmtLapKode', 'kmtKomen', 'kmtStatus', 'kmtIndkKode'];
}
