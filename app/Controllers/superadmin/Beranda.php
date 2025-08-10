<?php

namespace App\Controllers\superadmin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;
use App\Models\IndeksKProvinsi_m;

class Beranda extends BaseController
{
    public function index()
    {
        $session = session();
        helper('form');
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'BERANDA'
        ];

        return view('superadmin/beranda/index', $data);
    }

    public function getIndeksKMap()
    {
        $session = session();
        if (!$session->get('cekLogin')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $bulan = $this->request->getGet('bulan') ?? date('n'); // Default bulan sekarang
        $tahun = $this->request->getGet('tahun') ?? date('Y'); // Default tahun sekarang

        $indeksModel = new IndeksKProvinsi_m();

        // Mapping kode provinsi ke ID SVG path, ambil data dari ProvinsiM
        $provinsiModel = new \App\Models\Ref\ProvinsiM();
        // Mapping kode provinsi ke ID SVG path
        $provinsiMapping = [];
        $provinsiData = $provinsiModel->findAll();
        foreach ($provinsiData as $provinsi) {
            $provinsiMapping[$provinsi['provNamaPendek']] = $provinsi['provIdSvg'];
        }

        try {
            $data = $indeksModel->where('kprovPeriodeBulan', $bulan)
                ->where('kprovPeriodeTahun', $tahun)
                ->where('kprovIsPublish', 1)
                ->findAll();

            $result = [];
            foreach ($data as $row) {
                $kodeProvinsi = $row['kprovDinKode'];
                if (isset($provinsiMapping[$kodeProvinsi])) {
                    $result[] = [
                        'pathId' => $provinsiMapping[$kodeProvinsi],
                        'indeksK' => $row['kprovIndeksK'],
                        'provinsi' => $kodeProvinsi
                    ];
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $result,
                'periode' => [
                    'bulan' => $bulan,
                    'tahun' => $tahun
                ]
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}
