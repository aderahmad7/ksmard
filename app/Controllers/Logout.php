<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Logout extends BaseController
{
    public function index()
    {
        // Destroy session
        session()->destroy();

        // Redirect to login page
        return redirect()->to('/login');
    }
}
