<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController
{
    public function index()
    {
        $session = session();
        $session->destroy();

        return view('auth-login');
    }

    public function cek()
    {
        $session = session();

        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required'
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required'
            ]
        ];

        $validation = service('validation');
        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('/login')
                ->withInput()
                ->with('validation', $validation);
        }


        $username = esc($this->request->getPost('username'));
        $password = esc($this->request->getPost('password'));

        $roleModel = new \App\Models\Superadmin\Role_m();
        $userModel = new \App\Models\User_m();

        $akun = $userModel->where('accUsername', $username)->first();
        $role = $roleModel->where('roleAccUsername', $username)->first();

        if (!$akun || !password_verify($password, $akun['accPassword'])) {
            return redirect()->to('/login')->with('error', 'Username atau Password salah!');
        }

        $session->set([
            'username' => $username,
            'nama' => $akun['accNama'], 
            'role' => $role['roleRole'],
            'cekLogin' => true
        ]);

        switch ($role['roleRole']) {
            case 'superadmin':
                return redirect()->to('/superadmin/beranda');
                break;
            case 'dinas':
                $session->set('kodeDinas', $role['roleKodeDinas']);
                return redirect()->to('/dinas/beranda');
                break;
            case 'pks':
                $session->set(['kodePKS' => $role['roleKodePKS'], 'kodeDinas' => $role['roleKodeDinas']]);
                return redirect()->to('/pks/beranda');
                break;
        }
    }
}
