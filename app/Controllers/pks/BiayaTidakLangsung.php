<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class BiayaTidakLangsung extends BaseController
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
        
        $biayaTLModel = new \App\Models\Pks\Periode_m();

        $periode = $biayaTLModel->where('indkPksKode', $kode_pks)->findAll();
        $periodeCb = [];
        foreach ($periode as $row => $val)
            $periodeCb[$val["indkKode"]] = bulan($val["indkPeriodeBulan"]) . " " . $val["indkPeriodeTahun"];

        $biayatlKategoriModell = new \App\Models\Ref\KategoriBiayaTL_m();
        $katBiayatl = $biayatlKategoriModell->findAll();
        $katBiayatlCb = [];
        foreach ($katBiayatl as $row => $val)
            $katBiayatlCb[$val["katbiayKode"]] = $val["katbiayNama"];

        $data = [
            'title' => 'BERANDA',
            'periode' => $periodeCb,
            'kategoriBiayaTL' => $katBiayatlCb,
        ];
        return view('pks/biaya_tidak_langsung/index', $data);
    }

    public function grid($menu = null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_t_biaya_tl_pks')
            ->select(
                '  biaytlKode,
                biaytlUraian,
                katbiayNama,
                biaytlVolume,
                biaytlTotal,
                biaytlKode'
            )
            ->join('ksmard_r_kat_biayatl_pks', 'ksmard_r_kat_biayatl_pks.katbiayKode = ksmard_t_biaya_tl_pks.biaytlKatbiayKode');

        return DataTable::of($builder)
            ->filter(function ($builder, $request) {
                if ($request->periode)
                    $builder->where('biaytlIndkKode', $request->periode);
            })->toJson(true);
    }

    public function simpan()
    {
        helper("currency_helper");
        $rules = [
            'biaytlUraian' => ['label' => 'Uraian', 'rules' => 'required'],
            'biaytlKatbiayKode' => ['label' => 'Kategori', 'rules' => 'required'],
            'biaytlTotal' => ['label' => 'Total', 'rules' => 'required'],
            'biaytlVolume' => ['label' => 'Volume', 'rules' => 'required'],
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

        $biayaTLModel = new \App\Models\Pks\BiayaTL_m();

        $post = $this->request->getPost();
        $kode = $post["kode"];
        unset($post["kode"]);
        $model = $biayaTLModel->find($kode);
        if ($model) {
            $exist = $biayaTLModel->where($post)->first();
            if ($exist) {
                if ($kode != $exist['biaytlKode']) {
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan' => "Gagal mengubah data. Periode sudah pernah dibuat!"
                    ]);
                    return;
                }
            }
            $post["biaytlTotal"] = toDecimal($post["biaytlTotal"]);
            $post["biaytlVolume"] = toDecimal($post["biaytlVolume"]);

            $biayaTLModel->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {


            $post["biaytlTotal"] = toDecimal($post["biaytlTotal"]);
            $post["biaytlVolume"] = toDecimal($post["biaytlVolume"]);

            $biayaTLModel->save($post);
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
            'biaytlKode' => ['label' => 'ID', 'rules' => 'required|is_natural']
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
        $biayaTLModel = new \App\Models\Pks\BiayaTL_m();

        $post = $this->request->getPost();
        unset($post["kode"]);
        $exist = $biayaTLModel->where($post)->first();
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

        $biayaTLModel = new \App\Models\Pks\BiayaTL_m();
        $periode = $biayaTLModel->find($id);
        if (!$periode) {
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $periode = $biayaTLModel->delete($id);
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
