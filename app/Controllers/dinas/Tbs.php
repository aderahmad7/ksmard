<?php

namespace App\Controllers\Dinas;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Tbs extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        log_message('info', print_r($session->get('kodeDinas'), true));

        $data = [
            'title' => 'TBS'
        ];

        return view('dinas/tbs', $data);
    }
}
