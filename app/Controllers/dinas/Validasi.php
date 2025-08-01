<?php

namespace App\Controllers\Dinas;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;
use App\Models\IndeksKProvinsi_m;
use App\Models\Dinas\Pks_m;
use App\Models\Pks\Periode_m;

class Validasi extends BaseController
{
    public function __construct(){
        $this->indeksKModel = new IndeksKProvinsi_m();
        $this->pksModel = new Pks_m();
        $this->periodePksModel = new Periode_m();
        helper('form');
        helper("datetime_helper");
        helper("dropdown_helper");
        helper("currency_helper");
        $this->session = session();
        $this->kode_dinas = $this->session->get('kodeDinas');
        if (!$this->session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }
    }
    public function index()
    {
        $periode =$this->indeksKModel->where('kprovDinKode', $this->kode_dinas)->findAll();
        $periodeCb = [];
        foreach ($periode as $row=>$val)
            $periodeCb[$val["kprovKode"]]=bulan($val["kprovPeriodeBulan"])." ".$val["kprovPeriodeTahun"];
        $data = [
            'title' => 'Validasi',
            'periode'=>$periodeCb
        ];
        return view('dinas/validasi/index', $data); 
    }

    public function listPerusahaan()
    {
        $rules = [
            'periode' => ['label' => 'Periode', 'rules' => 'required|is_natural'],
        ];
        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => false,
                'data' => null,
                'pesan' => $validation->getErrors()
            ]);
            return;
        }

        $periode = $this->request->getPost("periode");
        $periodeData = $this->indeksKModel->where("kprovKode",$periode)->first();
        $pksData = $this->pksModel->where("pksDinasKode",$this->kode_dinas)->findAll();
        $pksIndeksKData = $this->periodePksModel ->where("indkDinasKode",$this->kode_dinas)
                                    ->where("indkPeriodeBulan",$periodeData["kprovPeriodeBulan"])
                                    ->where("indkPeriodeTahun",$periodeData["kprovPeriodeTahun"])
                                    ->whereIn('indkStatus', ["dikirim","revisi","divalidasi"])
                                ->findAll();
        if (!$pksData){
            return $this->response->setJSON([
                'status' => false,
                'data' => null,
                'pesan' => $validation->getErrors()
            ]);
            return;
        }
        //print_r($pksData);
        // 1. Buat mapping indeks berdasarkan kode PKS dari indeksK
        $indexedIndeksK = [];
        foreach ($pksIndeksKData as $indeks) {
            $kode = $indeks['indkPksKode'];
            $indexedIndeksK[$kode] = $indeks;
        }
        //print_r($pksIndeksKData);

        // 2. Gabungkan dengan $pksData berdasarkan pksKode
        $combined = [];
        foreach ($pksData as $pks) {
            $kode = $pks['pksKode'];
            $indeks = $indexedIndeksK[$kode] ?? [
                    "indkKode"=>null,
                    "indkDinasKode"=>null,
                    "indkPksKode"=>null,
                    "indkPeriodeBulan"=>null,
                    "indkPeriodeTahun"=>null,
                    "indkIndeksK"=>null,
                    "indkStatus"=>null
            ];
             // Hitung nourut
            $status = $indeks['indkStatus'] ?? null;
            $nourut = match($status) {
                'dikirim'     => 1,
                'revisi'      => 2,
                'divalidasi'  => 3,
                default       => 4
            };
            $combined[] = array_merge($pks, $indeks, ['nourut' => $nourut]);
        }
        // 3. Urutkan berdasarkan nourut ascending
        usort($combined, fn($a, $b) => $a['nourut'] <=> $b['nourut']);
       //print_r($combined);
         return $this->response->setJSON([
                'status' => true,
                'validasi' => false,
                'data' => $combined
            ]);
    }

    public function simpan()
    {
        $rules = [
            'kprovPeriodeBulan' => ['label' => 'Periode Bulan', 'rules' => 'required|is_natural|max_length[2]'],
            'kprovPeriodeTahun' => ['label' => 'Periode Tahun', 'rules' => 'required|is_natural|max_length[4]']
        ];
        if ($this->request->getPost("kode") != null)
            $rules['kode'] = ['label' => 'ID', 'rules' => 'required|is_natural'];
        
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

        $post = $this->request->getPost();
       
        $kode = $post["kode"];

        unset($post["kode"]);
        $model = $this->model->find($kode);
        if ($model) {
            $exist = $this->model->where($post)->first();
            log_message('info', print_r($exist, true));
            if ($exist) {
                if ($kode != $exist['kprovKode']) {
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan' => "Gagal mengubah data. Periode sudah pernah dibuat!"
                    ]);
                    return;
                }
            }
            log_message('info', print_r($post, true));
            $this->model->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
            $exist = $this->model->where($post)->first();

            if ($exist != null) {
                return $this->response->setJSON([
                    'simpan' => false,
                    'validasi' => true,
                    'pesan' => "Gagal menambahkan data. Periode sudah pernah dibuat!"
                ]);
                return;
            }

            log_message('info', print_r($post, true));

            $this->model->insert([
                'kprovDinKode' => $this->kode_dinas,
                'kprovPeriodeBulan' => $post["kprovPeriodeBulan"],
                'kprovPeriodeTahun' => $post["kprovPeriodeTahun"],
            ]);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
    }

    public function simpan_indeks_k()
    {
         $rules = [
            'kode_periode' => ['label' => 'Kode', 'rules' => 'required'],
            'kprovIndeksK' => ['label' => 'Indeks K', 'rules' => 'required'],
            'kprovTanggalPenetapan' => ['label' => 'Tanggal', 'rules' => 'required'],
            'kprovIsPublish' => ['label' => 'Dipublish?', 'rules' => 'required']
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

        $post = $this->request->getPost();
        $kode = $post["kode_periode"];
        $post['kprovTanggalPenetapan'] = to_mysql_date($post['kprovTanggalPenetapan']);
        //print_r($post);
        unset($post["kode_periode"]);
        $model = $this->model->find($kode);
        if ($model) {
            $exist = $this->model
                    ->where("kprovDinKode",$this->kode_dinas)
                    ->where("kprovIsPublish",1)
                    ->first();
            
            log_message('info', print_r($exist, true));
            if ($exist && $post["kprovIsPublish"]==1) {
                if ($exist["kprovKode"]!=$kode) {

                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan' => "Gagal menyimpan, karena masih ada periode dalam status 'Publish'. Silahkan ubah status 'Tidak Dipublish' pada periode tersebut"
                    ]);
                    return;
                }
            }
            log_message('info', print_r($post, true));
            $this->model->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
            $exist = $this->model->where($post)->first();

            if ($exist != null) {
                return $this->response->setJSON([
                    'simpan' => false,
                    'validasi' => true,
                    'pesan' => "Gagal menambahkan data. Periode sudah pernah dibuat!"
                ]);
                return;
            }

            log_message('info', print_r($post, true));

            $this->model->insert([
                'kprovDinKode' => $this->kode_dinas,
                'kprovPeriodeBulan' => $post["kprovPeriodeBulan"],
                'kprovPeriodeTahun' => $post["kprovPeriodeTahun"],
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
            'kprovKode' => ['label' => 'ID', 'rules' => 'required|is_natural']
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
       
        $post = $this->request->getPost();
        unset($post["kode"]);
        $exist = $this->model->where($post)->first();
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

        $periode = $this->model->find($id);
        if (!$periode) {
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $periode = $this->model->delete($id);
        if ($periode) {
            return $this->response->setJSON([
                'hapus' => true,
                'pesan' => 'Berhasil menghapus data!'
            ]);
        }
    }

}
