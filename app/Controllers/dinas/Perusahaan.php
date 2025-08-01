<?php

namespace App\Controllers\Dinas;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Perusahaan extends BaseController
{
    public function index($kodePks)
    {
        $session = session();
        helper('form');
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $session->set('kodePks', $kodePks);

        $data = [
            'title' => 'PERUSAHAAN'
        ];

        return view('dinas/perusahaan/index', $data);
    }

    
}
