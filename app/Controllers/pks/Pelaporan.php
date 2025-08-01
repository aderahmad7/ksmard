<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;
use App\Models\Pks\Periode_m;
use App\Models\Pks\Rekap_m;
use App\Models\Komentar_m;

class Pelaporan extends BaseController
{
    public $session_kode_pks;

    public function __construct()
    {
        $this->session = session();
        $this->periodeModel = new Periode_m();
        $this->rekapModel = new Rekap_m();
        $this->komentarModel = new Komentar_m();
        helper('form');
        helper("datetime_helper");
        helper("dropdown_helper");
        if (!$this->session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }
        $this->session_kode_pks = $this->session->get('kodePKS');
        $this->session_kode_dinas = $this->session->get('kodeDinas');
    }
    public function index($id=null)
    {
        log_message('info', print_r($this->session->get('kodePKS'), true));
        $selected = (isset($_SESSION['periode_set']) ? $_SESSION['periode_set'] : '');
        if ($id!=null)
            $selected = $id;

        $periode = $this->periodeModel->where('indkPksKode', $this->session_kode_pks)->findAll();
        $periodeCb = [];
        foreach ($periode as $row => $val)
            $periodeCb[$val["indkKode"]] = bulan($val["indkPeriodeBulan"]) . " " . $val["indkPeriodeTahun"];
        $data = [
            'title' => 'Indeks K Perusahaan',
            'periode' => $periodeCb,
            'selected' =>$selected,
            'id'=>$id
        ];
        return view('pks/pelaporan/index', $data);
    }




    public function kirim()
    {
        $periodeData = $this->GetPeriode('periode');
        if (!$periodeData['status']){
            return $this->response->setJSON([
                'simpan' => false,
                'validasi' => false,
                'pesan' => $periodeData['error']
            ]);
            return;
        }
        
        $periodeData=$periodeData["data"];

        if (in_array($periodeData['indkStatus'], $this->periodeNoInput)){
            return $this->response->setJSON([
                'simpan' => false,
                'validasi' => true,
                'pesan' => 'Gagal menyimpan!!, Periode sudah dikirim'
            ]);
            return;
        }
        $periode = $periodeData['indkKode'];
        $existRekap = $this->rekapModel->where('rekapIndkKode', $periode)->findAll();
        
        if (!empty($existRekap)) {
            //echo 1;
            $this->rekapModel->where('rekapIndkKode',$periode)->delete();
            //echo $this->rekapModel->getLastQuery();
        }
        $kData=$this->kalkulasiIndeksK($periode);
        $rekapArr[]=["rekapLapKode"=>1,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>$kData["fob"]["cpo_ekspor"],"rekapCpoLokal"=>$kData["fob"]["cpo_lokal"],"rekapKernelEkspor"=>$kData["fob"]["inti_ekspor"],"rekapKernelLokal"=>$kData["fob"]["inti_lokal"],"rekapTbs"=>null];
        $rekapArr[]=["rekapLapKode"=>2,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>$kData["pajak"]["cpo_ekspor"],"rekapCpoLokal"=>$kData["pajak"]["cpo_lokal"],"rekapKernelEkspor"=>$kData["pajak"]["inti_ekspor"],"rekapKernelLokal"=>$kData["pajak"]["inti_lokal"],"rekapTbs"=>null];
        $rekapArr[]=["rekapLapKode"=>3,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>$kData["pemasaran"]["cpo_ekspor"],"rekapCpoLokal"=>$kData["pemasaran"]["cpo_lokal"],"rekapKernelEkspor"=>$kData["pemasaran"]["inti_ekspor"],"rekapKernelLokal"=>$kData["pemasaran"]["inti_lokal"],"rekapTbs"=>null];
        $rekapArr[]=["rekapLapKode"=>4,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>$kData["fob_bersih"]["cpo_ekspor"],"rekapCpoLokal"=>$kData["fob_bersih"]["cpo_lokal"],"rekapKernelEkspor"=>$kData["fob_bersih"]["inti_ekspor"],"rekapKernelLokal"=>$kData["fob_bersih"]["inti_lokal"],"rekapTbs"=>null];
        $rekapArr[]=["rekapLapKode"=>5,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>$kData["angkut"]["cpo_ekspor"],"rekapCpoLokal"=>$kData["angkut"]["cpo_lokal"],"rekapKernelEkspor"=>$kData["angkut"]["inti_ekspor"],"rekapKernelLokal"=>$kData["angkut"]["inti_lokal"],"rekapTbs"=>null];
        $rekapArr[]=["rekapLapKode"=>6,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>$kData["harga_bersih"]["cpo_ekspor"],"rekapCpoLokal"=>$kData["harga_bersih"]["cpo_lokal"],"rekapKernelEkspor"=>$kData["harga_bersih"]["inti_ekspor"],"rekapKernelLokal"=>$kData["harga_bersih"]["inti_lokal"],"rekapTbs"=>null];
        $rekapArr[]=["rekapLapKode"=>7,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>$kData["rendemen"]["cpo_ekspor"],"rekapCpoLokal"=>$kData["rendemen"]["cpo_lokal"],"rekapKernelEkspor"=>$kData["rendemen"]["inti_ekspor"],"rekapKernelLokal"=>$kData["rendemen"]["inti_lokal"],"rekapTbs"=>null];
        $rekapArr[]=["rekapLapKode"=>8,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>$kData["harga_tbs"]["cpo_ekspor"],"rekapCpoLokal"=>$kData["harga_tbs"]["cpo_lokal"],"rekapKernelEkspor"=>$kData["harga_tbs"]["inti_ekspor"],"rekapKernelLokal"=>$kData["harga_tbs"]["inti_lokal"],"rekapTbs"=>null];
        $rekapArr[]=["rekapLapKode"=>9,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>$kData["vol_jual"]["cpo_ekspor"],"rekapCpoLokal"=>$kData["vol_jual"]["cpo_lokal"],"rekapKernelEkspor"=>$kData["vol_jual"]["inti_ekspor"],"rekapKernelLokal"=>$kData["vol_jual"]["inti_lokal"],"rekapTbs"=>null];
        $rekapArr[]=["rekapLapKode"=>10,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>$kData["expabrik"]["cpo_ekspor"],"rekapCpoLokal"=>$kData["expabrik"]["cpo_lokal"],"rekapKernelEkspor"=>$kData["expabrik"]["inti_ekspor"],"rekapKernelLokal"=>$kData["expabrik"]["inti_lokal"],"rekapTbs"=>$kData["expabrik"]["total"]];
        $rekapArr[]=["rekapLapKode"=>11,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>null,"rekapCpoLokal"=>null,"rekapKernelEkspor"=>null,"rekapKernelLokal"=>null,"rekapTbs"=>$kData["pengolahan"]];
        $rekapArr[]=["rekapLapKode"=>12,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>null,"rekapCpoLokal"=>null,"rekapKernelEkspor"=>null,"rekapKernelLokal"=>null,"rekapTbs"=>$kData["penyusutan"]];
        $rekapArr[]=["rekapLapKode"=>13,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>null,"rekapCpoLokal"=>null,"rekapKernelEkspor"=>null,"rekapKernelLokal"=>null,"rekapTbs"=>$kData["harga_timbangan"]];
        $rekapArr[]=["rekapLapKode"=>14,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>null,"rekapCpoLokal"=>null,"rekapKernelEkspor"=>null,"rekapKernelLokal"=>null,"rekapTbs"=>$kData["biayatl"]];
        $rekapArr[]=["rekapLapKode"=>15,"rekapIndkKode"=>$periode,"rekapCpoEkspor"=>null,"rekapCpoLokal"=>null,"rekapKernelEkspor"=>null,"rekapKernelLokal"=>null,"rekapTbs"=>$kData["harga_tbs_pabrik"]];
        $this->rekapModel->insertBatch($rekapArr);
        //print_r($existRekap);exit;
         // Cek apakah ada komentar dengan indkKode yang sama
        $existKomentar = $this->komentarModel->where('kmtIndkKode', $periode)->findAll();

        if ($existKomentar) {
            // Ubah status 'ditolak' menjadi 'pending'
            $this->komentarModel->where('kmtIndkKode', $periode)
                ->where('kmtStatus', 'ditolak')
                ->set([
                    'kmtStatus' => 'pending',
                    'kmtKomen' => ''
                ])
                ->update();

            log_message('info', print_r($periode, true));


            $this->periodeModel->where('indkKode', $periode)
                ->set('indkStatus', 'dikirim')
                ->update();

            log_message('info', 'aman');


            return $this->response->setJSON([
                'kirim' => true,
                'pesan' => 'Data sudah pernah dikirim. Status "revisi" diubah menjadi "pending".'
            ]);
        } else {
            
            // Insert 15 baris data baru
            $data=[];
            for ($i = 1; $i <= 15; $i++) {
                $data[] = [
                                'kmtLapKode' => $i,
                                'kmtIndkKode'  => $periode,
                                'kmtStatus'  => 'Pending',
                            ];
            }

            $this->komentarModel->insertBatch($data);

            $this->periodeModel->where('indkKode', $periode)
                ->set('indkStatus', 'dikirim')
                ->update();

            return $this->response->setJSON([
                'kirim' => true,
                'pesan' => 'Data berhasil dikirim!!.'
            ]);
        }
    }



    public function rekap()
    {
        $rules = [
            'periode' => ['label' => 'ID', 'rules' => 'required|is_natural']
        ];

        log_message('info', print_r($this->request->getPost("periode"), true));
        $this->session->set('periode_set', $this->request->getPost("periode"));

        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'rekap' => false,
                'pesan' => $validation->getErrors()
            ]);
            return;
        }

        
        $periodeData = $this->GetPeriode('periode');
        if (!$periodeData['status']){
            return $this->response->setJSON([
                'rekap' => false,
                'data' => $periodeData['error']
            ]);
            return;
        }
        
        $periodeData=$periodeData["data"];
        $kData=$this->kalkulasiIndeksK($periodeData["indkKode"]);

        if ($periodeData['indkStatus']=="draft" || $periodeData['indkStatus']=="revisi"){
            
            $periode["indkIndeksK"] = $kData["indeks_k"];
            $periode =  $this->periodeModel->update($periodeData["indkKode"], $periode);
    
        }

        

        $existKomentar = $this->komentarModel->where('kmtIndkKode', $periodeData["indkKode"])->findAll();
        return $this->response->setJSON([
            'rekap' => true,
            'data' => $kData,
            'periode' => $periodeData,
            'komentar' => $existKomentar
        ]);
    }

    private function kalkulasiIndeksK($periode){
        $penjualanModel = new \App\Models\Pks\Penjualan_m();
        $pajakModel = new \App\Models\Pks\Pajak_m();
        $pemasaranModel = new \App\Models\Pks\Pemasaran_m();
        $pengangkutanModel = new \App\Models\Pks\Pengangkutan_m();
        $produksiModel = new \App\Models\Pks\Produksi_m();
        $tbsDiolahModel = new \App\Models\Pks\ProduksiDiolah_m();
        $produksiHasilModel = new \App\Models\Pks\ProduksiHasil_m();
        $pengolahanModel = new \App\Models\Pks\Pengolahan_m();
        $penyusutanModel = new \App\Models\Pks\Penyusutan_m();
        $biayaTLModel = new \App\Models\Pks\BiayaTL_m();
        $dinasSettingModel = new \App\Models\Pks\Dinas_setting_m();
        $dinasSetting = $dinasSettingModel->where("dinsetDinKode",$this->session_kode_dinas)->first();
        
        $query["fob"] = $penjualanModel->getRekap($periode);
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
        $query["pajak"] = $pajakModel->getRekap($periode);
        $query["pemasaran"] = $pemasaranModel->getRekap($periode);
        $query["fob_bersih"] = [
            "cpo_ekspor" => $query["fob"]["cpo_ekspor"] - $query["pajak"]["cpo_ekspor"] - $query["pemasaran"]["cpo_ekspor"],
            "cpo_lokal" => $query["fob"]["cpo_lokal"] - $query["pajak"]["cpo_lokal"] - $query["pemasaran"]["cpo_lokal"],
            "inti_ekspor" => $query["fob"]["inti_ekspor"] - $query["pajak"]["inti_ekspor"] - $query["pemasaran"]["inti_ekspor"],
            "inti_lokal" => $query["fob"]["inti_lokal"] - $query["pajak"]["inti_lokal"] - $query["pemasaran"]["inti_lokal"],
        ];
        $query["angkut"] = $pengangkutanModel->getRekap($periode);
        $query["harga_bersih"] = [
            "cpo_ekspor" => $query["fob_bersih"]["cpo_ekspor"] - $query["angkut"]["cpo_ekspor"],
            "cpo_lokal" => $query["fob_bersih"]["cpo_lokal"] - $query["angkut"]["cpo_lokal"],
            "inti_ekspor" => $query["fob_bersih"]["inti_ekspor"] - $query["angkut"]["inti_ekspor"],
            "inti_lokal" => $query["fob_bersih"]["inti_lokal"] - $query["angkut"]["inti_lokal"],
        ];
        $produksi = $tbsDiolahModel->getRekap($periode);
        //echo $tbsDiolahModel->getLastQuery();exit;
        $produksiHasil = $produksiHasilModel->getRekap($periode);
        $cpo_rendemen_raw = $produksi["volume"]== 0 ? 0 : $produksiHasil["cpo"] / $produksi["volume"];
        $inti_rendemen_raw = $produksi["volume"]== 0 ? 0 : $produksiHasil["inti"] / $produksi["volume"];
        $cpo_ekspor_rendemen_persen = round($query["fob"]["cpo_ekspor"] == 0 ? 0 : $cpo_rendemen_raw * 100, 2);
        $inti_lokal_rendemen_persen = round($query["fob"]["inti_lokal"] == 0 ? 0 : $inti_rendemen_raw * 100, 2);
        $cpo_lokal_rendemen_persen = round($query["fob"]["cpo_lokal"] == 0 ? 0 : $cpo_rendemen_raw * 100, 2);
        $inti_ekspor_rendemen_persen = round($query["fob"]["inti_ekspor"] == 0 ? 0 : $inti_rendemen_raw * 100, 2);
        $query["rendemen"] = [
            "cpo_ekspor" => ($cpo_ekspor_rendemen_persen),
            "cpo_lokal" => ($cpo_lokal_rendemen_persen),
            "inti_ekspor" => ($inti_ekspor_rendemen_persen),
            "inti_lokal" => ($inti_lokal_rendemen_persen),
        ];
        $tbs_cpo_ekspor = round($query["harga_bersih"]["cpo_ekspor"] * ($cpo_ekspor_rendemen_persen / 100), 2);
        $tbs_cpo_lokal = round($query["harga_bersih"]["cpo_lokal"] * ($cpo_lokal_rendemen_persen / 100), 2);
        $tbs_inti_ekspor = round($query["harga_bersih"]["inti_ekspor"] * ($inti_ekspor_rendemen_persen / 100), 2);
        $tbs_inti_lokal = round($query["harga_bersih"]["inti_lokal"] * ($inti_lokal_rendemen_persen / 100), 2);
        $query["harga_tbs"] = [
            "cpo_ekspor" => $tbs_cpo_ekspor,
            "cpo_lokal" => $tbs_cpo_lokal,
            "inti_ekspor" => $tbs_inti_ekspor,
            "inti_lokal" => $tbs_inti_lokal,
        ];
        if (!$dinasSetting || $dinasSetting["dinsetPersenJual"]==null){

            $jual_cpo_ekspor_raw = round(($produksiHasil["cpo"]==0 ? 0 : $query["fob"]["cpo_ekspor_vol"] / $produksiHasil["cpo"]) * 100, 2);
            $jual_cpo_lokal_raw = round(($produksiHasil["cpo"]==0 ? 0 : $query["fob"]["cpo_lokal_vol"] / $produksiHasil["cpo"]) * 100, 2);

            $jual_inti_ekspor_raw = round($produksiHasil["inti"]==0 ? 0 : $query["fob"]["inti_ekspor_vol"] / $produksiHasil["inti"] * 100, 2);
            $jual_inti_lokal_raw = round($produksiHasil["inti"]==0 ? 0 : $query["fob"]["inti_lokal_vol"] / $produksiHasil["inti"] * 100, 2);
        } else {
            $jual_cpo_ekspor_raw = $query["fob"]["cpo_ekspor"] == 0 ? 0 : $dinasSetting["dinsetPersenJual"];
            $jual_cpo_lokal_raw =$query["fob"]["cpo_lokal"] == 0 ? 0 : $dinasSetting["dinsetPersenJual"];

            $jual_inti_ekspor_raw = $query["fob"]["inti_ekspor"] == 0 ? 0 : $dinasSetting["dinsetPersenJual"];
            $jual_inti_lokal_raw = $query["fob"]["inti_lokal"] == 0 ? 0 : $dinasSetting["dinsetPersenJual"];
        }
        //print_r($query["fob"]);exit;
        $query["vol_jual"] = [
            "cpo_ekspor" => $jual_cpo_ekspor_raw,
            "cpo_lokal" => $jual_cpo_lokal_raw,
            "inti_ekspor" => $jual_inti_ekspor_raw,
            "inti_lokal" => $jual_inti_lokal_raw,
        ];

        $expabrik_cpo_ekspor_raw = round($tbs_cpo_ekspor * ($jual_cpo_ekspor_raw / 100), 2);
        $expabrik_cpo_lokal_raw = round($tbs_cpo_lokal * ($jual_cpo_lokal_raw / 100), 2);
        $expabrik_inti_ekspor_raw = round($tbs_inti_ekspor * ($jual_inti_ekspor_raw / 100), 2);
        $expabrik_inti_lokal_raw = round($tbs_inti_lokal * ($jual_inti_lokal_raw / 100), 2);
        $total_expabrik = $expabrik_cpo_ekspor_raw + $expabrik_cpo_lokal_raw + $expabrik_inti_ekspor_raw + $expabrik_inti_lokal_raw;
        $query["expabrik"] = [
            "cpo_ekspor" => $expabrik_cpo_ekspor_raw,
            "cpo_lokal" => ($expabrik_cpo_lokal_raw),
            "inti_ekspor" => $expabrik_inti_ekspor_raw,
            "inti_lokal" => ($expabrik_inti_lokal_raw),
            "total" => $total_expabrik
        ];

        $query_pengolahan = $pengolahanModel->getRekap($periode);
        $query["pengolahan"] = ($produksi["volume"]==0?0:$query_pengolahan["total_pengolahan"] / $produksi["volume"]);
        $query["pengolahan"] = round(floatval($query["pengolahan"]), 2);

        $query_penyusutan = $penyusutanModel->getRekap($periode);
        $query["penyusutan"] = ($produksi["volume"]==0?0:$query_penyusutan["total_penyusutan"] / $produksi["volume"]);
        $query["penyusutan"] = round(floatval($query["penyusutan"]), 2);

        $harga_timbangan = $total_expabrik - $query["pengolahan"] - $query["penyusutan"];
        $query["harga_timbangan"] = $harga_timbangan;

        $query_biayatl = $biayaTLModel->getRekap($periode);
        
        if (!$dinasSetting){
            $query["biayatl_label"]="Belum diset.";
            $query["biayatl"] = 0;
        } else {
            $query["biayatl_label"] = $dinasSetting["dinsetPersenBotl"]."%";
            $query["biayatl"] = $query["harga_timbangan"] * ($dinasSetting["dinsetPersenBotl"]/100);
        }
        
        $query["biayatl"] = round(floatval($query["biayatl"]), 2);

        $harga_tbs_pabrik = $harga_timbangan - $query["biayatl"];
        $query["harga_tbs_pabrik"] = $harga_tbs_pabrik;
        $cpo_bersih = $this->fob_bersih_rerate($query["fob_bersih"]["cpo_lokal"],$query["fob_bersih"]["cpo_ekspor"]);
        $inti_bersih = $this->fob_bersih_rerate($query["fob_bersih"]["inti_lokal"],$query["fob_bersih"]["inti_ekspor"]);
        $indeks_k = $harga_tbs_pabrik / (($cpo_bersih * ($cpo_lokal_rendemen_persen / 100)) + ($inti_bersih * ($inti_lokal_rendemen_persen / 100)));
        $query["indeks_k"] = round(floatval($indeks_k * 100), 2);
        return $query;
    }

    private function fob_bersih_rerate($a,$b){
        if ($a != 0) $nilai[] = $a;
        if ($b != 0) $nilai[] = $b;

        $rerata = count($nilai) > 0 ? array_sum($nilai) / count($nilai) : 0;
        return $rerata;
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
        if (!$this->session->get('cekLogin')) {
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
        if (!$this->session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'PENGATURAN'
        ];
        return view('perusahaan/pengembangan', $data);
    }
}
