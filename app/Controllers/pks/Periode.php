<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Periode extends BaseController
{
    public function index()
    {
        $session = session();
        helper('form');
        helper("datetime_helper");
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Periode',
            'kodePKS' => session()->get('kodePKS'),
            'kodeDinas' => session()->get('kodeDinas')
        ];
        return view('pks/periode/index', $data);
    }

    public function grid($menu = null)
    {

        // get data session 
        log_message('info', print_r(session()->get('kodeDinas'), true));

        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_t_indeks_k_pks')
            ->select('  indkKode,
                                indkDinasKode,
                                indkPeriodeBulan,
                                indkPeriodeTahun,
                                indkIndeksK, 
                                indkStatus')
            ->where('indkDinasKode', session()->get('kodeDinas'))
            ->where('indkPksKode', session()->get('kodePKS'));

        return DataTable::of($builder)->toJson(true);
    }

    public function simpan()
    {
        $rules = [
            'indkPeriodeBulan' => ['label' => 'Periode Bulan', 'rules' => 'required|is_natural|max_length[2]'],
            'indkPeriodeTahun' => ['label' => 'Periode Tahun', 'rules' => 'required|is_natural|max_length[4]']
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

        $periodeModel = new \App\Models\Pks\Periode_m();

        $post = $this->request->getPost();
        $kode = $post["kode"];
        unset($post["kode"]);
        $model = $periodeModel->find($kode);
        if ($model) {
            $exist = $periodeModel->where($post)->first();
            log_message('info', print_r($exist, true));
            if ($exist) {
                if ($kode != $exist['indkKode']) {
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan' => "Gagal mengubah data. Periode sudah pernah dibuat!"
                    ]);
                    return;
                }
            }
            log_message('info', print_r($post, true));
            $periodeModel->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
            $exist = $periodeModel->where($post)->first();

            if ($exist != null) {
                return $this->response->setJSON([
                    'simpan' => false,
                    'validasi' => true,
                    'pesan' => "Gagal menambahkan data. Periode sudah pernah dibuat!"
                ]);
                return;
            }

            log_message('info', print_r($post, true));

            $periodeModel->insert([
                'indkDinasKode' => $post["indkDinasKode"],
                'indkPksKode' => $post["indkPksKode"],
                'indkPeriodeBulan' => $post["indkPeriodeBulan"],
                'indkPeriodeTahun' => $post["indkPeriodeTahun"],
            ]);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
    }

    public function edit()
    {
        $rules = [
            'indkKode' => ['label' => 'ID', 'rules' => 'required|is_natural']
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
        $periodeModel = new \App\Models\Pks\Periode_m();

        $post = $this->request->getPost();
        unset($post["kode"]);
        $exist = $periodeModel->where($post)->first();
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

        $periodeModel = new \App\Models\Pks\Periode_m();
        $periode = $periodeModel->find($id);
        if (!$periode) {
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $periode = $periodeModel->delete($id);
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

    public function detail_periode($indkKode)
    {
        helper('form');
        $session = session();


        $data = [
            'title' => 'PERUSAHAAN',
            'periode' => $indkKode
        ];

        log_message('info', print_r($data, true));

        return view('pks/detail_periode/index', $data);
    }

    public function rekap()
    {
        $rules = [
            'periode' => ['label' => 'ID', 'rules' => 'required|is_natural']
        ];

        log_message('info', print_r($this->request->getPost(), true));

        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'rekap' => false,
                'pesan' => $validation->getErrors()
            ]);
            return;
        }

        $penjualanModel = new \App\Models\Pks\Penjualan_m();
        $pajakModel = new \App\Models\Pks\Pajak_m();
        $pemasaranModel = new \App\Models\Pks\Pemasaran_m();
        $pengangkutanModel = new \App\Models\Pks\Pengangkutan_m();
        $produksiModel = new \App\Models\Pks\Produksi_m();
        $produksiHasilModel = new \App\Models\Pks\ProduksiHasil_m();
        $pengolahanModel = new \App\Models\Pks\Pengolahan_m();
        $penyusutanModel = new \App\Models\Pks\Penyusutan_m();
        $biayaTLModel = new \App\Models\Pks\BiayaTL_m();
        $komentarModel = new \App\Models\Komentar_m();
        $komentar = $komentarModel->select('kmtStatus as status, kmtKomen as komen, kmtKode as komenKode')->where('kmtIndkKode', $this->request->getPost("periode"))->findAll();
        $query["fob"] = $penjualanModel->getRekap($this->request->getPost("periode"));
        $query["fob"] = [
            "cpo_ekspor" => $query["fob"]["cpo_ekspor_vol"] == 0 ? 0 : $query["fob"]["cpo_ekspor"] / $query["fob"]["cpo_ekspor_vol"],
            "cpo_ekspor_vol" => $query["fob"]["cpo_ekspor_vol"],
            "cpo_lokal" => round($query["fob"]["cpo_lokal"] / $query["fob"]["cpo_lokal_vol"], 2),
            "cpo_lokal_vol" => $query["fob"]["cpo_lokal_vol"],
            "inti_ekspor" => $query["fob"]["inti_ekspor_vol"] == 0 ? 0 : $query["fob"]["inti_ekspor"] / $query["fob"]["inti_ekspor_vol"],
            "inti_ekspor_vol" => $query["fob"]["inti_ekspor_vol"],
            "inti_lokal" => round($query["fob"]["inti_lokal_vol"] == 0 ? 0 : $query["fob"]["inti_lokal"] / $query["fob"]["inti_lokal_vol"], 2),
            "inti_lokal_vol" => $query["fob"]["inti_lokal_vol"],
            'status' => $komentar[0]['status'],
            'komen_kode' => $komentar[0]['komenKode'],
        ];
        $query["pajak"] = $pajakModel->getRekap($this->request->getPost("periode"));
        $query["pajak"] += [
            "status" => $komentar[1]['status'],
            "komen_kode" => $komentar[1]['komenKode'],
        ];

        $query["pemasaran"] = $pemasaranModel->getRekap($this->request->getPost("periode"));
        $query["pemasaran"] += [
            "status" => $komentar[2]['status'],
            "komen_kode" => $komentar[2]['komenKode'],
        ];

        $query["fob_bersih"] = [
            "cpo_ekspor" => $query["fob"]["cpo_ekspor"] - $query["pajak"]["cpo_ekspor"] - $query["pemasaran"]["cpo_ekspor"],
            "cpo_lokal" => $query["fob"]["cpo_lokal"] - $query["pajak"]["cpo_lokal"] - $query["pemasaran"]["cpo_lokal"],
            "inti_ekspor" => $query["fob"]["inti_ekspor"] - $query["pajak"]["inti_ekspor"] - $query["pemasaran"]["inti_ekspor"],
            "inti_lokal" => $query["fob"]["inti_lokal"] - $query["pajak"]["inti_lokal"] - $query["pemasaran"]["inti_lokal"],
            'status' => $komentar[3]['status'],
            'komen_kode' => $komentar[3]['komenKode'],
        ];
        $query["angkut"] = $pengangkutanModel->getRekap($this->request->getPost("periode"));
        $query["angkut"] += [
            "status" => $komentar[4]['status'],
            "komen_kode" => $komentar[4]['komenKode'],
        ];

        $query["harga_bersih"] = [
            "cpo_ekspor" => $query["fob_bersih"]["cpo_ekspor"] - $query["angkut"]["cpo_ekspor"],
            "cpo_lokal" => $query["fob_bersih"]["cpo_lokal"] - $query["angkut"]["cpo_lokal"],
            "inti_ekspor" => $query["fob_bersih"]["inti_ekspor"] - $query["angkut"]["inti_ekspor"],
            "inti_lokal" => $query["fob_bersih"]["inti_lokal"] - $query["angkut"]["inti_lokal"],
            'status' => $komentar[5]['status'],
            'komen_kode' => $komentar[5]['komenKode'],
        ];
        $produksi = $produksiModel->getRekap($this->request->getPost("periode"));
        $produksiHasil = $produksiHasilModel->getRekap($this->request->getPost("periode"));
        $cpo_rendemen_raw = $produksiHasil["cpo"] / $produksi["volume"];
        $inti_rendemen_raw = $produksiHasil["inti"] / $produksi["volume"];
        $cpo_rendemen_persen = round($cpo_rendemen_raw * 100, 2);
        $inti_rendemen_persen = round($inti_rendemen_raw * 100, 2);
        $query["rendemen"] = [
            "cpo_ekspor" => 0,
            "cpo_lokal" => ($cpo_rendemen_persen),
            "inti_ekspor" => 0,
            "inti_lokal" => ($inti_rendemen_persen),
            'status' => $komentar[6]['status'],
            'komen_kode' => $komentar[6]['komenKode'],
        ];
        $tbs_cpo_ekspor = 0;
        $tbs_cpo_lokal = round($query["harga_bersih"]["cpo_lokal"] * ($cpo_rendemen_persen / 100), 2);
        $tbs_inti_ekspor = 0;
        $tbs_inti_lokal = round($query["harga_bersih"]["inti_lokal"] * ($inti_rendemen_persen / 100), 2);
        $query["harga_tbs"] = [
            "cpo_ekspor" => $tbs_cpo_ekspor,
            "cpo_lokal" => $tbs_cpo_lokal,
            "inti_ekspor" => $tbs_inti_ekspor,
            "inti_lokal" => $tbs_inti_lokal,
            'status' => $komentar[7]['status'],
            'komen_kode' => $komentar[7]['komenKode'],
        ];

        $jual_cpo_ekspor_raw = 0;
        $jual_cpo_lokal_raw = round(($query["fob"]["cpo_lokal_vol"] / $produksiHasil["cpo"]) * 100, 2);

        $jual_inti_ekspor_raw = 0;
        $jual_inti_lokal_raw = round($query["fob"]["inti_lokal_vol"] / $produksiHasil["inti"] * 100, 2);
        //print_r($query["fob"]);exit;
        $query["vol_jual"] = [
            "cpo_ekspor" => 0,
            "cpo_lokal" => 100,
            "inti_ekspor" => 0,
            "inti_lokal" => 100,
            'status' => $komentar[8]['status'],
            'komen_kode' => $komentar[8]['komenKode'],
        ];

        $expabrik_cpo_ekspor_raw = $tbs_cpo_ekspor * $jual_cpo_ekspor_raw;
        $expabrik_cpo_lokal_raw = round($tbs_cpo_lokal * ($jual_cpo_lokal_raw / 100), 2);
        $expabrik_inti_ekspor_raw = $tbs_inti_ekspor * $jual_inti_ekspor_raw;
        $expabrik_inti_lokal_raw = round($tbs_inti_lokal * ($jual_inti_lokal_raw / 100), 2);
        $total_expabrik = $expabrik_cpo_ekspor_raw + $expabrik_cpo_lokal_raw + $expabrik_inti_ekspor_raw + $expabrik_inti_lokal_raw;
        $query["expabrik"] = [
            "cpo_ekspor" => $expabrik_cpo_ekspor_raw,
            "cpo_lokal" => ($expabrik_cpo_lokal_raw),
            "inti_ekspor" => $expabrik_inti_ekspor_raw,
            "inti_lokal" => ($expabrik_inti_lokal_raw),
            "total" => $total_expabrik,
            'status' => $komentar[9]['status'],
            'komen_kode' => $komentar[9]['komenKode'],
        ];

        $query_pengolahan = $pengolahanModel->getRekap($this->request->getPost("periode"));
        $query["pengolahan"] = ($query_pengolahan["total_pengolahan"] / $produksi["volume"]);
        $query["pengolahan"] = [
            "total" => round(floatval($query["pengolahan"]), 2),
            'status' => $komentar[10]['status'],
            'komen_kode' => $komentar[10]['komenKode'],
        ];

        $query_penyusutan = $penyusutanModel->getRekap($this->request->getPost("periode"));
        $query["penyusutan"] = ($query_penyusutan["total_penyusutan"] / $produksi["volume"]);
        $query["penyusutan"] = [
            "total" => round(floatval($query["penyusutan"]), 2),
            'status' => $komentar[11]['status'],
            'komen_kode' => $komentar[11]['komenKode'],
        ];

        $harga_timbangan = $total_expabrik - $query["pengolahan"]["total"] - $query["penyusutan"]["total"];
        $query["harga_timbangan"] = [
            "total" => $harga_timbangan,
            'status' => $komentar[12]['status'],
            'komen_kode' => $komentar[12]['komenKode'],
        ];

        $query_biayatl = $biayaTLModel->getRekap($this->request->getPost("periode"));
        $query["biayatl_label"] = "1,58%";
        $query["biayatl"] = $query["harga_timbangan"]["total"] * 0.0158;
        $query["biayatl"] = [
            "total" => round(floatval($query["biayatl"]), 2),
            'status' => $komentar[13]['status'],
            'komen_kode' => $komentar[13]['komenKode'],
        ];

        $harga_tbs_pabrik = $harga_timbangan - $query["biayatl"]["total"];
        $query["harga_tbs_pabrik"] = [
            "total" => $harga_tbs_pabrik,
            'status' => $komentar[14]['status'],
            'komen_kode' => $komentar[14]['komenKode'],
        ];

        $indeks_k = $harga_tbs_pabrik / (($query["fob_bersih"]["cpo_lokal"] * ($cpo_rendemen_persen / 100)) + ($query["fob_bersih"]["inti_lokal"] * ($inti_rendemen_persen / 100)));
        $query["indeks_k"] = round(floatval($indeks_k * 100), 2);

        return $this->response->setJSON([
            'rekap' => true,
            'data' => $query
        ]);
    }
}
