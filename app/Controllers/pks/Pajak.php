<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;
use App\Models\Pks\Periode_m;
use App\Models\Pks\Pajak_m;
class Pajak extends BaseController
{
    public function __construct(){
        $this->periodeModel = new Periode_m();
        $this->model = new Pajak_m();
        $this->session = session();
        helper('form');
        helper("datetime_helper");
        helper("dropdown_helper");
        helper("currency_helper");
    }
    public function index()
    {
       
        helper('form');
        helper("datetime_helper");
        helper("dropdown_helper");
        if (!$this->session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }
        $kode_pks = $this->session->get('kodePKS');
        $periode = $this->periodeModel->where('indkPksKode', $kode_pks)->findAll();
        $periodeCb = [];
        foreach ($periode as $row=>$val)
            $periodeCb[$val["indkKode"]]=bulan($val["indkPeriodeBulan"])." ".$val["indkPeriodeTahun"];
        $data = [
            'title' => 'Pajak',
            'periode'=>$periodeCb
        ];
        return view('pks/pajak/index', $data);
    }

    public function grid($menu=null)
    {
        $db = db_connect();
        helper("datetime_helper");
        helper("dropdown_helper");
        $builder = $db->table('ksmard_t_pajak_pks')
                    ->select('  pjkKode,
                                pjkUraian,
                                pjkTbsKode,
                                pjkIsEkspor,
                                pjkTotal,
                                pjkVolume,
                                pjkKomentar,
                                indkStatus'
                                )
                     ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_pajak_pks.pjkIndkKode');
        
        
        return DataTable::of($builder)
                 ->edit('pjkTbsKode', function($row, $meta){
                    return getKategoriTbs($row->pjkTbsKode);
                })
                ->filter(function ($builder, $request) {
                
                    if ($request->periode)
                        $builder->where('pjkIndkKode', $request->periode);
            
                })->toJson(true);
    }

    public function simpan()
    {
        $periodeData = $this->GetPeriode('pjkIndkKode');
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
            'pjkUraian' => ['label' => 'Uraian', 'rules' => 'required'],
            'pjkIsEkspor' => ['label' => 'Jenis Penjualan', 'rules' => 'required'],
            'pjkTbsKode' => ['label' => 'Jenis TBS', 'rules' => 'required'],
            'pjkTotal' => ['label' => 'Total', 'rules' => 'required'],
            'pjkVolume' => ['label' => 'Volume', 'rules' => 'required'],
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
                if ($kode!=$exist['pjkKode']){
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan' => "Gagal mengubah data. Periode sudah pernah dibuat!"
                    ]);
                    return; 
                }
            }
            $post["pjkTotal"] = toDecimal($post["pjkTotal"]);
            $post["pjkVolume"] = toDecimal($post["pjkVolume"]);
            $this->model->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
        
            
            $post["pjkTotal"] = toDecimal($post["pjkTotal"]);
            $post["pjkVolume"] = toDecimal($post["pjkVolume"]);
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
            'pjkKode' => ['label' => 'ID', 'rules' => 'required|is_natural']
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
        
        $hapus = $this->model->find($id);
        if (!$hapus){
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $perhapusiode = $this->model->delete($id);
        if ($perhapusiode){
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

       
        $rekap = $this->model->getRekap($this->request->getPost("periode"));
        $query = [
            "cpo_ekspor"   => $rekap["cpo_ekspor"],
            "cpo_lokal"   => $rekap["cpo_lokal"],
            "inti_ekspor"   => $rekap["cpo_ekspor"],
            "inti_lokal"   => $rekap["inti_lokal"],
            
        ];
        
        return $this->response->setJSON([
            'rekap' => true,
            'data' => $query
        ]);
    }

    
}
