<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;
use App\Models\Pks\Periode_m;
use App\Models\Pks\ProduksiHasil_m;

class Hasil extends BaseController
{
    public function __construct(){
        $this->periodeModel = new Periode_m();
        $this->model = new ProduksiHasil_m();
        $this->session = session();
        helper('form');
        helper("datetime_helper");
        helper("dropdown_helper");
        helper("currency_helper");
    }
    public function index()
    {
       
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }
       
        $periode = $this->session->where('indkPksKode', 'ABS')->findAll();
        $periodeCb = [];
        foreach ($periode as $row=>$val)
            $periodeCb[$val["indkKode"]]=bulan($val["indkPeriodeBulan"])." ".$val["indkPeriodeTahun"];
        $data = [
            'title' => 'BERANDA',
            'periode'=>$periodeCb
        ];
        return view('pks/produksi/index', $data);
    }

    public function grid($menu=null)
    {
        $db = db_connect();
        helper("datetime_helper");
        helper("dropdown_helper");
        $builder = $db->table('ksmard_t_produksi_hasil_pks')
                    ->select('  hasilKode,
                                hasilJenisHasil,
                                hasilVolume,hasilKomentar, indkStatus'
                                )
                    ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_produksi_hasil_pks.hasilIndkKode');
            
        
        return DataTable::of($builder)
                ->edit('hasilJenisHasil', function($row, $meta){
                    return getKategoriTbs($row->hasilJenisHasil);
                })
                ->filter(function ($builder, $request) {
                
                    if ($request->periode)
                        $builder->where('hasilIndkKode', $request->periode);
            
                })->toJson(true);
    }

    public function simpan()
    {
        helper("currency_helper");
        $periodeData = $this->GetPeriode('hasilIndkKode');
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
            'hasilJenisHasil' => ['label' => 'Jenis Hasil', 'rules' => 'required'],
            'hasilVolume' => ['label' => 'Volume', 'rules' => 'required']
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
        $kode=$post["kodehasil"];
        unset($post["kodehasil"]);
        $model = $this->model->find($kode);
        if ($model){
            $exist = $this->model->where($post)->first();
            if ($exist){
                if ($kode!=$exist['hasilKode']){
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan' => "Gagal mengubah data. Periode sudah pernah dibuat!"
                    ]);
                    return; 
                }
            }
            $post["hasilVolume"] = toDecimal($post["hasilVolume"]);
            
            $this->model->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
        
            
            $post["hasilVolume"] = toDecimal($post["hasilVolume"]);
            
            $this->model->save($post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
        
        
    }

    public function format_rupiah_to_decimal($val){
        $val = str_replace("Rp. ", "", $val);
        $val = str_replace(".", "", $val);
        $val = str_replace(",", ".", $val);
        return $val;
    }

    public function edit()
    {
        $rules = [
            'hasilKode' => ['label' => 'ID', 'rules' => 'required|is_natural']
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
        $produksiModel = new \App\Models\Pks\ProduksiHasil_m();

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
}
