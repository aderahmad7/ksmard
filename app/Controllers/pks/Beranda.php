<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;
use App\Models\Pks\Periode_m;
use App\Models\Pks\Rekap_m;
use App\Models\IndeksKProvinsi_m;

class Beranda extends BaseController
{
    public function __construct(){
        helper('form');
        helper("datetime_helper");
        helper("dropdown_helper");
        helper("currency_helper");
        $this->periodeModel = new Periode_m();
        $this->model = new Rekap_m();
        $this->indeksKProvinsiModel = new IndeksKProvinsi_m();
        $this->session = session();
        $this->session_kode_dinas = $this->session->get('kodeDinas');
        $this->session_kode_pks = $this->session->get('kodePKS');
        
        if (!$this->session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }
    }
    public function index()
    {
       
        $indeksKProv = $this->indeksKProvinsiModel
            ->where("kprovDinKode",$this->session_kode_dinas)
            ->where("kprovIsPublish",1)
            ->first();
        $indKProv["indeks_k_provinsi"] = 0;
        $indKProv["indeks_k_provinsi_label"] = "Belum Ditetapkan";
        $indKProv["indeks_k_provinsi_tanggal"] = "";
        $indKProv["indeks_k_provinsi_bulan"] = "";
        $indKProv["indeks_k_provinsi_tahun"] = "";
        //echo $this->indeksKProvinsiModel->getLastQuery();
        //print_r($indeksKProv);exit;
        if ($indeksKProv){
            $indKProv["indeks_k_provinsi"] = $indeksKProv["kprovIndeksK"];
            $indKProv["indeks_k_provinsi_label"] = "";
            $indKProv["indeks_k_provinsi_tanggal"] = $indeksKProv["kprovTanggalPenetapan"];
            $indKProv["indeks_k_provinsi_bulan"] = $indeksKProv["kprovPeriodeBulan"];
            $indKProv["indeks_k_provinsi_tahun"] = $indeksKProv["kprovPeriodeTahun"];
        }

        $data = [
            'title' => 'Dashboard',
            'k_prov' =>$indKProv,
            'rekap_indeks_k'=>$this->model->getDashboardRekap(date('Y'),$this->session_kode_dinas,$this->session_kode_pks),
            'tahun'=>$this->periodeModel->getTahunArr($this->session_kode_pks)
        ];
        return view('pks/beranda/index', $data);
    }

    public function getIndeksK()
    {
        $rules = [
            'indeks_k_tahun' => ['label' => 'Tahun', 'rules' => 'required|is_natural']
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

        $tahun = $this->request->getPost('indeks_k_tahun');
       
       
        $data = $this->model->getDashboardRekap($tahun,$this->session_kode_dinas,$this->session_kode_pks);
        return $this->response->setJSON([
                'rekap' => true,
                'data' => $data,
            ]);
            return;
    }

    public function grid($menu=null)
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
        $rules = [
            'indkPeriodeBulan' => ['label' => 'Periode Bulan', 'rules' => 'required|is_natural|max_length[2]'],
            'indkPeriodeTahun' => ['label' => 'Periode Tahun', 'rules' => 'required|is_natural|max_length[4]']
        ];
        if ($this->request->getPost("kode")!=null)
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
        $kode=$post["kode"];
        unset($post["kode"]);
        $model = $periodeModel->find($kode);
        if ($model){
            $exist = $periodeModel->where($post)->first();
            if ($exist){
                if ($kode!=$exist['indkKode']){
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan' => "Gagal mengubah data. Periode sudah pernah dibuat!"
                    ]);
                    return; 
                }
            }
            $periodeModel->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
        
            $exist = $periodeModel->where($post)->first();
            
            if ($exist!=null){
                return $this->response->setJSON([
                    'simpan' => false,
                    'validasi' => true,
                    'pesan' => "Gagal menambahkan data. Periode sudah pernah dibuat!"
                ]);
                return;
            }
            $periodeModel->save($post);
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
        if ($exist){
            return $this->response->setJSON([
                'edit' => true,
                'data' => $exist
            ]);
        }
        
        
        
    }

    public function hapus() {
        
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
        if (!$periode){
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $periode = $periodeModel->delete($id);
        if ($periode){
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
