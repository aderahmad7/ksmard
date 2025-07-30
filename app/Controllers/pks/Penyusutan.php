<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Penyusutan extends BaseController
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

        $penyusutanModel = new \App\Models\Pks\Periode_m();

        $periode = $penyusutanModel->where('indkPksKode', $kode_pks)->findAll();
        $periodeCb = [];
        foreach ($periode as $row => $val)
            $periodeCb[$val["indkKode"]] = bulan($val["indkPeriodeBulan"]) . " " . $val["indkPeriodeTahun"];

        $penyusutanKategoriModel = new \App\Models\Ref\KategoriPenyusutan_m();
        $katPenyusutan = $penyusutanKategoriModel->findAll();
        $katPenyusutanCb = [];
        foreach ($katPenyusutan as $row => $val)
            $katPenyusutanCb[$val["katusutKode"]] = $val["katusutNama"];

        $data = [
            'title' => 'BERANDA',
            'periode' => $periodeCb,
            'kategoriPenyusutan' => $katPenyusutanCb,
        ];
        return view('pks/penyusutan/index', $data);
    }

    public function grid($menu = null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_t_penyusutan_pks')
            ->select(
                '  usutKode,
                                usutUraian,
                                katusutNama,
                                usutTotal,
                                usutKode'
            )
            ->join('ksmard_r_kat_penyusutan_pks', 'ksmard_r_kat_penyusutan_pks.katusutKode = ksmard_t_penyusutan_pks.usutKatusutKode');

        return DataTable::of($builder)
            ->filter(function ($builder, $request) {

                if ($request->periode)
                    $builder->where('usutIndkKode', $request->periode);
            })->toJson(true);
    }

    public function simpan()
    {
        helper("currency_helper");
        $rules = [
            'usutUraian' => ['label' => 'Uraian', 'rules' => 'required'],
            'usutKatusutKode' => ['label' => 'Kategori', 'rules' => 'required'],
            'usutTotal' => ['label' => 'Total', 'rules' => 'required'],
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

        $penyusutanModel = new \App\Models\Pks\Penyusutan_m();

        $post = $this->request->getPost();
        $kode = $post["kode"];
        unset($post["kode"]);
        $model = $penyusutanModel->find($kode);
        if ($model) {
            $exist = $penyusutanModel->where($post)->first();
            if ($exist) {
                if ($kode != $exist['usutKode']) {
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan' => "Gagal mengubah data. Periode sudah pernah dibuat!"
                    ]);
                    return;
                }
            }
            $post["usutTotal"] = toDecimal($post["usutTotal"]);
            $penyusutanModel->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {


            $post["usutTotal"] = toDecimal($post["usutTotal"]);

            $penyusutanModel->save($post);
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
            'usutKode' => ['label' => 'ID', 'rules' => 'required|is_natural']
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
        $penyusutanModel = new \App\Models\Pks\Penyusutan_m();

        $post = $this->request->getPost();
        unset($post["kode"]);
        $exist = $penyusutanModel->where($post)->first();
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

        $penyusutanModel = new \App\Models\Pks\Penyusutan_m();
        $periode = $penyusutanModel->find($id);
        if (!$periode) {
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $periode = $penyusutanModel->delete($id);
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
