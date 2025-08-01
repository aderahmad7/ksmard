<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Profile extends BaseController
{
    public function index()
    {
        helper('form');
        helper("datetime_helper");
        helper("dropdown_helper");

        $roleModel = new \App\Models\Superadmin\Role_m();

        $account = $roleModel
            ->select('roleAccUsername, roleRole, accNama, accEmail, accNoWhatsapp')
            ->join('ksmard_t_account', 'ksmard_t_account.accUsername = ksmard_t_role.roleAccUsername')
            ->where('roleAccUsername', session()->get('username'))
            ->first();

        $data = [
            'title' => 'Profile',
            'account' => $account,
        ];

        return view('profile', $data);
    }

    public function simpan()
    {
        $rules = [
            'accUsername' => ['label' => 'Username', 'rules' => 'required'],
            'accNama' => ['label' => 'Nama', 'rules' => 'required'],
            'role' => ['label' => 'Role', 'rules' => 'required'],
        ];
        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'simpan' => false,
                'validasi' => false,
                'pesan' => $validation->getErrors()
            ]);
            return;
        }

        $accountModel = new \App\Models\User_m();

        $post = $this->request->getPost();
        unset($post["role"]);

        if ($accountModel->update($post["accUsername"], $post)) {
            return $this->response->setJSON([
                'simpan' => true,
                'pesan' => 'Data berhasil disimpan'
            ]);
        } else {
            return $this->response->setJSON([
                'simpan' => false,
                'pesan' => 'Data gagal disimpan'
            ]);
        }
    }

    public function ubah_password()
    {
        $rules = [
            'accPassword' => ['label' => 'Password Baru', 'rules' => 'required'],
            'accPasswordKonfirmasi' => ['label' => 'Konfirmasi Password Baru', 'rules' => 'required|matches[accPassword]'],
        ];
        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'simpan' => false,
                'validasi' => false,
                'pesan' => $validation->getErrors()
            ]);
            return;
        }

        $accountModel = new \App\Models\User_m();

        $post = $this->request->getPost();
        $post["accPassword"] = password_hash($post["accPassword"], PASSWORD_DEFAULT);
        unset($post["accPasswordKonfirmasi"]);

        if ($accountModel->update(session()->get('username'), $post)) {
            return $this->response->setJSON([
                'simpan' => true,
                'pesan' => 'Password berhasil diperbarui'
            ]);
        } else {
            return $this->response->setJSON([
                'simpan' => false,
                'pesan' => 'Gagal mengubah password'
            ]);
        }
    }
}
