<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dinas extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'BERANDA'
        ];
        return view('dinas/beranda', $data);
    }

    public function tbs()
    {
        $session = session();
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Data TBS'
        ];
        
        return view('dinas/tbs', $data);
    }
}
