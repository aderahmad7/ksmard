<?php

namespace App\Models\Ref;

use CodeIgniter\Model;

class KategoriDinasSettingM extends Model
{
    protected $table            = 'ksmard_r_dinas_setting';
    protected $primaryKey       = 'dinsetKode';
    protected $allowedFields = [
        'dinsetDinKode',
        'dinsetPersenBotl',
        'dinsetPersenJual',
    ];
}
