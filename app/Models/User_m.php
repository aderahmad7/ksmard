<?php
namespace App\Models;

use CodeIgniter\Model;

class User_m extends Model
{
    protected $table = 'ksmard_t_account';
    protected $primaryKey = 'accUsername';
    protected $allowedFields = ['accUsername', 'accPassword', 'accNama', 'accEmail', 'accNoWhatsapp'];
    protected $useTimestamps = true;
    protected $createdField = 'accCreatedAt';
    protected $updatedField = 'accUpdateAt';
}
?>