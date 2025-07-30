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

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        log_message('info', print_r($username, true));

        $roleModel = new \App\Models\Superadmin\Role_m();
        $userModel = new \App\Models\User_m();

        $akun = $userModel->where('accUsername', $username)->first();
        $role = $roleModel->where('roleAccUsername', $username)->first();

        if (!$akun || $akun['accPassword'] != $password) {
            return redirect()->back()->with('error', 'Invalid username or password');
        }

        $session->set([
            'username' => $username,
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
