<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Pelaporan extends BaseController
{
    public $session_kode_pks;

    public function __construct()
    {
        $this->session_kode_pks = "ABS";
    }
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

        log_message('info', print_r($session->get('kodePKS'), true));

        $produksiModel = new \App\Models\Pks\Periode_m();
        $periode = $produksiModel->where('indkPksKode', $kode_pks)->findAll();
        $periodeCb = [];
        foreach ($periode as $row => $val)
            $periodeCb[$val["indkKode"]] = bulan($val["indkPeriodeBulan"]) . " " . $val["indkPeriodeTahun"];
        $data = [
            'title' => 'BERANDA',
            'periode' => $periodeCb
        ];
        return view('pks/pelaporan/index', $data);
    }

    public function grid($menu = null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_t_indeks_k_pks')
            ->select('  indkKode,
                                indkDinasKode,
                                indkPeriodeBulan,
                                indkPeriodeTahun,
                                indkIndeksK, 
                                indkStatus');

        return DataTable::of($builder)->toJson(true);
    }

    public function simpan()
    {
        $indeks_k = $this->request->getPost("indeks_k");
        $periode = $this->request->getPost("periode");

        log_message('info', print_r($indeks_k, true));

        $periodeModel = new \App\Models\Pks\Periode_m();
        $periode = $periodeModel->find($periode);
        $periode["indkIndeksK"] = $indeks_k;
        $periode = $periodeModel->update($periode["indkKode"], $periode);
        if ($periode) {
            return $this->response->setJSON([
                'simpan' => true,
                'pesan' => 'Berhasil menyimpan data!'
            ]);
        }
    }

    public function kirim()
    {
        $indeks_k = $this->request->getPost("indeks_k");
        $indeks_k_percentage = $this->request->getPost("indeks_k_percentage");
        log_message('info', print_r($this->request->getPost(), true));

        log_message('info', print_r($indeks_k, true));
        log_message('info', print_r($indeks_k_percentage, true));

        if (empty($indeks_k_percentage)) {
            return $this->response->setJSON([
                'kirim' => false,
                'pesan' => "Data belum lengkap!"
            ]);
        }

        $komentarModel = new \App\Models\Komentar_m();
        $periodeModel = new \App\Models\Pks\Periode_m();


        // Cek apakah ada komentar dengan indkKode yang sama
        $existKomentar = $komentarModel->where('kmtIndkKode', $indeks_k)->findAll();

        if ($existKomentar) {
            // Ubah status 'ditolak' menjadi 'pending'
            $komentarModel->where('kmtIndkKode', $indeks_k)
                ->where('kmtStatus', 'ditolak')
                ->set([
                    'kmtStatus' => 'pending',
                    'kmtKomen' => ''
                ])
                ->update();

            log_message('info', print_r($indeks_k, true));


            $periodeModel->where('indkKode', $indeks_k)
                ->set('indkStatus', 'dikirim')
                ->update();

            log_message('info', 'aman');


            return $this->response->setJSON([
                'kirim' => true,
                'pesan' => 'Data sudah pernah dikirim. Status "ditolak" diubah menjadi "pending".'
            ]);
        } else {
            // Insert 15 baris data baru
            for ($i = 1; $i <= 15; $i++) {
                $komentarModel->insert([
                    'kmtLapKode' => $i,
                    'kmtIndkKode' => $indeks_k,
                    'kmtStatus'   => 'pending' // atau default jika kolom status diisi otomatis
                ]);
            }

            $periodeModel->save([
                'indkStatus' => 'dikirim',
            ]);

            return $this->response->setJSON([
                'kirim' => true,
                'pesan' => 'Data berhasil dikirim sebanyak 15 entri.'
            ]);
        }
    }



    public function rekap()
    {
        $rules = [
            'periode' => ['label' => 'ID', 'rules' => 'required|is_natural']
        ];

        log_message('info', print_r($this->request->getPost("periode"), true));

        $session = session();
        $session->set('periode_set', $this->request->getPost("periode"));

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
        ];
        $query["pajak"] = $pajakModel->getRekap($this->request->getPost("periode"));
        $query["pemasaran"] = $pemasaranModel->getRekap($this->request->getPost("periode"));
        $query["fob_bersih"] = [
            "cpo_ekspor" => $query["fob"]["cpo_ekspor"] - $query["pajak"]["cpo_ekspor"] - $query["pemasaran"]["cpo_ekspor"],
            "cpo_lokal" => $query["fob"]["cpo_lokal"] - $query["pajak"]["cpo_lokal"] - $query["pemasaran"]["cpo_lokal"],
            "inti_ekspor" => $query["fob"]["inti_ekspor"] - $query["pajak"]["inti_ekspor"] - $query["pemasaran"]["inti_ekspor"],
            "inti_lokal" => $query["fob"]["inti_lokal"] - $query["pajak"]["inti_lokal"] - $query["pemasaran"]["inti_lokal"],
        ];
        $query["angkut"] = $pengangkutanModel->getRekap($this->request->getPost("periode"));
        $query["harga_bersih"] = [
            "cpo_ekspor" => $query["fob_bersih"]["cpo_ekspor"] - $query["angkut"]["cpo_ekspor"],
            "cpo_lokal" => $query["fob_bersih"]["cpo_lokal"] - $query["angkut"]["cpo_lokal"],
            "inti_ekspor" => $query["fob_bersih"]["inti_ekspor"] - $query["angkut"]["inti_ekspor"],
            "inti_lokal" => $query["fob_bersih"]["inti_lokal"] - $query["angkut"]["inti_lokal"],
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
            "total" => $total_expabrik
        ];

        $query_pengolahan = $pengolahanModel->getRekap($this->request->getPost("periode"));
        $query["pengolahan"] = ($query_pengolahan["total_pengolahan"] / $produksi["volume"]);
        $query["pengolahan"] = round(floatval($query["pengolahan"]), 2);

        $query_penyusutan = $penyusutanModel->getRekap($this->request->getPost("periode"));
        $query["penyusutan"] = ($query_penyusutan["total_penyusutan"] / $produksi["volume"]);
        $query["penyusutan"] = round(floatval($query["penyusutan"]), 2);

        $harga_timbangan = $total_expabrik - $query["pengolahan"] - $query["penyusutan"];
        $query["harga_timbangan"] = $harga_timbangan;

        $query_biayatl = $biayaTLModel->getRekap($this->request->getPost("periode"));
        $query["biayatl_label"] = "1,58%";
        $query["biayatl"] = $query["harga_timbangan"] * 0.0158;
        $query["biayatl"] = round(floatval($query["biayatl"]), 2);

        $harga_tbs_pabrik = $harga_timbangan - $query["biayatl"];
        $query["harga_tbs_pabrik"] = $harga_tbs_pabrik;

        $indeks_k = $harga_tbs_pabrik / (($query["fob_bersih"]["cpo_lokal"] * ($cpo_rendemen_persen / 100)) + ($query["fob_bersih"]["inti_lokal"] * ($inti_rendemen_persen / 100)));
        $query["indeks_k"] = round(floatval($indeks_k * 100), 2);
        return $this->response->setJSON([
            'rekap' => true,
            'data' => $query
        ]);
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
}
