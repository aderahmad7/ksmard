<?php

namespace App\Controllers\Dinas;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;


class Beranda extends BaseController
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

        $dinas_kode = $session->get('kodeDinas');

        $pemasaranModel = new \App\Models\Pks\Periode_m();

        $periode = $pemasaranModel->where('indkDinasKode', $dinas_kode)->findAll();
        $periodeCb = [];
        foreach ($periode as $row => $val)
            $periodeCb[$val["indkPeriodeBulan"]] = bulan($val["indkPeriodeBulan"]) . " " . $val["indkPeriodeTahun"];

        $pemasaranKategoriModel = new \App\Models\Ref\KategoriPemasaran_m();
        $katPemasaran = $pemasaranKategoriModel->findAll();


        $data = [
            'title' => 'BERANDA',
            'periode' => $periodeCb,
        ];

        return view('dinas/beranda/index', $data);
    }

    public function perusahaan()
    {
        $data_periode = $this->request->getPost('periode');

        $kode_dinas = session()->get('kodeDinas');


        $komenModel = new \App\Models\Komentar_m();
        $data = $komenModel
            ->select('
                ksmard_t_komentar.kmtIndkKode,
                ksmard_t_indeks_k_pks.indkIndeksK, 
                ksmard_t_indeks_k_pks.indkPksKode, 
                ksmard_m_pks.pksNama, 
                ksmard_t_indeks_k_pks.indkKode
            ')
            ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_komentar.kmtIndkKode')
            ->join('ksmard_m_pks', 'ksmard_m_pks.pksKode = ksmard_t_indeks_k_pks.indkPksKode')
            ->groupBy('ksmard_t_komentar.kmtIndkKode')
            ->where('ksmard_t_indeks_k_pks.indkDinasKode', $kode_dinas)
            ->where('ksmard_t_indeks_k_pks.indkPeriodeBulan', $data_periode)
            ->where('ksmard_t_indeks_k_pks.indkIndeksK !=', null)
            ->findAll();

        if (!$data) {
            return $this->response->setJSON($data);
        }

        foreach ($data as $i => $item) {
            $statusList = $komenModel
                ->select('kmtStatus')
                ->where('kmtIndkKode', $item["kmtIndkKode"])
                ->findAll();

            if (!$statusList) {
                $data[$i]["semua_diterima"] = false;
                continue;
            }

            $semua_diterima = true;
            foreach ($statusList as $status) {
                if ($status["kmtStatus"] !== "diterima") {
                    $semua_diterima = false;
                    break;
                }
            }

            $data[$i]["semua_diterima"] = $semua_diterima;
        }

        return $this->response->setJSON($data);
    }

    public function data_perusahaan($indkKode)
    {
        helper('form');
        $session = session();


        $data = [
            'title' => 'PERUSAHAAN',
            'periode' => $indkKode
        ];

        return view('dinas/perusahaan/index', $data);
    }

    public function rekap()
    {
        $rules = [
            'periode' => ['label' => 'ID', 'rules' => 'required|is_natural']
        ];

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

        $statusList = $komentarModel->select('kmtStatus')->where('kmtIndkKode', $this->request->getPost("periode"))->findAll();

        if ($statusList) {
            $hasRejected = false;
            $hasPending = false;
            $allApproved = true;

            foreach ($statusList as $statusItem) {
                $statusValue = strtolower($statusItem['kmtStatus']);
                if ($statusValue === 'ditolak') {
                    $hasRejected = true;
                    $allApproved = false;
                } elseif ($statusValue === 'pending') {
                    $hasPending = true;
                    $allApproved = false;
                } elseif ($statusValue !== 'diterima') {
                    $allApproved = false;
                }
            }

            $periodeModel = new \App\Models\Pks\Periode_m();
            $periodeId = $this->request->getPost("periode");

            if ($allApproved) {
                // Semua komentar telah disetujui
                $periodeModel->where('indkKode', $periodeId)
                    ->set('indkStatus', 'divalidasi')
                    ->update();
            } elseif ($hasRejected && !$hasPending) {
                // Terdapat komentar yang ditolak tetapi tidak ada yang pending
                $periodeModel->where('indkKode', $periodeId)
                    ->set('indkStatus', 'revisi')
                    ->update();
            } else {
                // Masih ada komentar dengan status pending
                $periodeModel->where('indkKode', $periodeId)
                    ->set('indkStatus', 'dikirim')
                    ->update();
            }
        }

        return $this->response->setJSON([
            'rekap' => true,
            'data' => $query
        ]);
    }

    public function edit()
    {
        $kode_komen = $this->request->getPost("kodeKomen");

        $komentarModel = new \App\Models\Komentar_m();
        $komentar = $komentarModel
            ->select('kmtKomen, kmtStatus,kmtKode')
            ->where('kmtKode', $kode_komen)
            ->first();

        return $this->response->setJSON([
            'edit' => true,
            'data' => $komentar
        ]);
    }

    public function simpan()
    {
        $rules = [
            'kmtKomen' => ['label' => 'Komentar', 'rules' => 'required'],
        ];

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

        $komentarModel = new \App\Models\Komentar_m();
        $komentarModel
            ->where('kmtKode', $this->request->getPost("kmtKode"))
            ->set([
                'kmtKomen' => $this->request->getPost("kmtKomen"),
                'kmtStatus' => $this->request->getPost("kmtStatus"),
            ])
            ->update();

        return $this->response->setJSON([
            'simpan' => true,
            'pesan' => "Data berhasil disimpan"
        ]);
    }
}
