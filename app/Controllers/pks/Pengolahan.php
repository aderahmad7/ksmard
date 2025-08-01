<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;
use App\Models\Pks\Periode_m;
use App\Models\Pks\Pengolahan_m;

class Pengolahan extends BaseController
{
    public function __construct(){
        $this->periodeModel = new Periode_m();
        $this->model = new Pengolahan_m();
        $this->session = session();
        helper('form');
        helper("datetime_helper");
        helper("dropdown_helper");
        helper("currency_helper");
    }
    public function index()
    {
       
        if (!$this->session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $kode_pks = $this->session->get('kodePKS');
        
        
        
        $periode = $this->periodeModel->where('indkPksKode', $kode_pks)->findAll();
        $periodeCb = [];
        foreach ($periode as $row=>$val)
            $periodeCb[$val["indkKode"]]=bulan($val["indkPeriodeBulan"])." ".$val["indkPeriodeTahun"];

        $pengolahanKategoriModel = new \App\Models\Ref\KategoriPengolahan_m();
        $katPengolahan = $pengolahanKategoriModel->findAll();
        $katPengolahanCb = [];
        foreach ($katPengolahan as $row=>$val)
            $katPengolahanCb[$val["katolahNama"]][$val["katolahKode"]]=$val["katolahSubNama"];

        $data = [
            'title' => 'Biaya Pengolahan',
            'periode'=>$periodeCb,
            'kategoriPengolahan'=>$katPengolahanCb,
        ];
        return view('pks/pengolahan/index', $data);
    }

    public function grid($menu=null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_t_pengolahan_pks')
                    ->select('  olahKode,
                                olahUraian,
                                katolahNama,
                                katolahSubNama,
                                olahTotal,
                                olahKomentar,
                                indkStatus,
                                olahKode'
                                )
                    ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_pengolahan_pks.olahIndkKode')
                    ->join('ksmard_r_kat_pengolahan_pks', 'ksmard_r_kat_pengolahan_pks.katolahKode = ksmard_t_pengolahan_pks.olahKatolahKode');
                               
        return DataTable::of($builder)
                ->filter(function ($builder, $request) {
                
                    if ($request->periode)
                        $builder->where('olahIndkKode', $request->periode);
            
                })->toJson(true);
    }

    public function simpan()
    {
        $periodeData = $this->GetPeriode('olahIndkKode');
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
        $rules = [
            'olahUraian' => ['label' => 'Uraian', 'rules' => 'required'],
            'olahKatolahKode' => ['label' => 'Kategori', 'rules' => 'required'],
            'olahTotal' => ['label' => 'Total', 'rules' => 'required'],
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

        

        $post = $this->request->getPost();
        $kode=$post["kode"];
        unset($post["kode"]);
        $model = $this->model->find($kode);
        if ($model){
            $exist = $this->model->where($post)->first();
            if ($exist){
                if ($kode!=$exist['olahKode']){
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan' => "Gagal mengubah data. Periode sudah pernah dibuat!"
                    ]);
                    return; 
                }
            }
            $post["olahTotal"] = toDecimal($post["olahTotal"]);
            $this->model->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
        
            
            $post["olahTotal"] = toDecimal($post["olahTotal"]);
            
            $this->model->save($post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
        
        
    }

    public function format_rupiah_to_decimal($val){
        $val = str_replace("Rp ", "", $val);
        $val = str_replace("Rp. ", "", $val);
        $val = str_replace(".", "", $val);
        $val = str_replace(",", ".", $val);
        return $val;
    }

    public function edit()
    {
        $rules = [
            'olahKode' => ['label' => 'ID', 'rules' => 'required|is_natural']
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
        $exist =$this->model->where($post)->first();
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
        ;
        $periode = $this->model->find($id);
        if (!$periode){
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $periode = $this->model->delete($id);
        if ($periode){
            return $this->response->setJSON([
                'hapus' => true,
                'pesan' => 'Berhasil menghapus data!'
            ]);
        }
    
    }

    public function periode()
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

       
        $input=false;
        if (in_array($periodeData['indkStatus'], $this->periodeYesInput))
            $input=true;
       
        return $this->response->setJSON([
            'status' => true,
            'input' =>$input,
            'data' => $periodeData
        ]);
        return;
        
        
        
    }

    public function rekap()
    {
        $rules = [
            'periode' => ['label' => 'ID', 'rules' => 'required|is_natural']
        ];

        log_message('info', print_r($this->request->getPost("periode"), true));

        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'rekap' => false,
                'pesan' => $validation->getErrors()
            ]);
            return;
        }

        $periode = $this->request->getPost("periode");
        
        $tbsDiolahModel = new \App\Models\Pks\ProduksiDiolah_m();
        $produksi = $tbsDiolahModel->getRekap($periode);
        $rekap = $this->model->getRekap($periode);
        $query = [
            "rekap_olah_total"   => $rekap["total_pengolahan"],
            "rekap_olah_perkg"   => safe_div($rekap["total_pengolahan"],$produksi["volume"]),
            
        ];
        
        return $this->response->setJSON([
            'rekap' => true,
            'data' => $query
        ]);
    }
}
