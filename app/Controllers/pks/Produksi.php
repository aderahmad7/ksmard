<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Produksi extends BaseController
{
    public function index()
    {
        $session = session();
        helper('form');
        helper("datetime_helper");
        helper("dropdown_helper");
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }
        $kode_pks = $session->get('kodePKS');
        
        $produksiModel = new \App\Models\Pks\Periode_m();
        $periode = $produksiModel->where('indkPksKode', $kode_pks)->findAll();
        $periodeCb = [];
        foreach ($periode as $row => $val)
            $periodeCb[$val["indkKode"]] = bulan($val["indkPeriodeBulan"]) . " " . $val["indkPeriodeTahun"];
        $data = [
            'title' => 'BERANDA',
            'periode' => $periodeCb
        ];
        return view('pks/produksi/index', $data);
    }

    public function grid($menu = null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_t_produksi_pks')
            ->select(
                '  prodKode,
                                prodJenisProduksi,
                                prodVolume'
            );

        return DataTable::of($builder)
            ->filter(function ($builder, $request) {
                if ($request->periode)
                    log_message('debug', $request->periode);
                $builder->where('prodIndkKode', $request->periode);
            })->toJson(true);
    }

    public function simpan()
    {
        helper("currency_helper");
        $rules = [
            'prodJenisProduksi' => ['label' => 'Jenis Produksi', 'rules' => 'required'],
            'prodVolume' => ['label' => 'Volume', 'rules' => 'required']
        ];
        if ($this->request->getPost("kode") != null)
            $rules['kode'] = ['label' => 'ID', 'rules' => 'required|is_natural'];
        //print_r($rules);exit;
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

        $produksiModel = new \App\Models\Pks\Produksi_m();

        $post = $this->request->getPost();
        $kode = $post["kode"];
        unset($post["kode"]);
        $model = $produksiModel->find($kode);
        if ($model) {
            $exist = $produksiModel->where($post)->first();
            if ($exist) {
                log_message('debug', print_r('prodKode' . $exist["prodKode"], true));
                log_message('debug', print_r('kode' . $kode, true));
                log_message('debug', print_r($kode != $exist['prodKode'], true));
                if ($kode != $exist['prodKode']) {
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan' => "Gagal mengubah data. Periode sudah pernah dibuat!"
                    ]);
                    return;
                }
            }
            $post["prodVolume"] = toDecimal($post["prodVolume"]);

            $produksiModel->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {


            $post["prodVolume"] = toDecimal($post["prodVolume"]);

            $produksiModel->save($post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
    }

    public function format_rupiah_to_decimal($val)
    {
        $val = str_replace("Rp ", "", $val);
        $val = str_replace("Rp. ", "", $val);
        $val = str_replace(".", "", $val);
        $val = str_replace(",", ".", $val);
        return $val;
    }

    public function edit()
    {
        $rules = [
            'prodKode' => ['label' => 'ID', 'rules' => 'required|is_natural']
        ];

        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'edit' => false,
                'pesan' => $validation->getErrors()
            ]);
            return;
        }
        $produksiModel = new \App\Models\Pks\Produksi_m();

        $post = $this->request->getPost();
        unset($post["kode"]);
        $exist = $produksiModel->where($post)->first();
        if ($exist) {
            return $this->response->setJSON([
                'edit' => true,
                'data' => $exist
            ]);
        }
    }

    public function hapus()
    {

        $rules = [
            'id' => ['label' => 'ID', 'rules' => 'required|is_natural'],
        ];
        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return;
        }

        $id = $this->request->getPost("id");

        $produksiModel = new \App\Models\Pks\Produksi_m();
        $periode = $produksiModel->find($id);
        if (!$periode) {
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $periode = $produksiModel->delete($id);
        if ($periode) {
            return $this->response->setJSON([
                'hapus' => true,
                'pesan' => 'Berhasil menghapus data!'
            ]);
        }
    }

    public function pengguna()
    {
        $session = session();
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'PENGGUNA'
        ];
        return view('perusahaan/pengembangan', $data);
    }

    public function pengaturan()
    {
        $session = session();
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'PENGATURAN'
        ];
        return view('perusahaan/pengembangan', $data);
    }
}
