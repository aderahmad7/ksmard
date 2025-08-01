<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;
use App\Models\Pks\Periode_m;
use App\Models\Pks\Penjualan_m;
class Penjualan extends BaseController
{
    public function __construct(){
        $this->periodeModel = new Periode_m();
        $this->model = new Penjualan_m();
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
        
        //$penjualanModel = new \App\Models\Pks\Periode_m();
        $periode = $this->periodeModel->where('indkPksKode', $kode_pks)->findAll();
        $periodeCb = [];
        foreach ($periode as $row=>$val)
            $periodeCb[$val["indkKode"]]=bulan($val["indkPeriodeBulan"])." ".$val["indkPeriodeTahun"];
        $data = [
            'title' => 'Penjualan',
            'periode'=>$periodeCb
        ];
        return view('pks/penjualan/index', $data);
    }

    public function grid($menu=null)
    {
        $db = db_connect();
        helper("datetime_helper");
        helper("dropdown_helper");
        $builder = $db->table('ksmard_t_penjualan_pks')
                    ->select('  jualKode,
                                jualUraian,
                                jualTbsKode,
                                jualIsEkspor,
                                jualVolume,
                                jualHarga, 
                                jualTotal,
                                jualNoDokumen,
                                jualPembeli,
                                jualFile,
                                jualFileTipe,
                                jualTanggal,
                                jualKomentar,
                                indkStatus'

                                )
                    ->join('ksmard_t_indeks_k_pks', 'ksmard_t_indeks_k_pks.indkKode = ksmard_t_penjualan_pks.jualIndkKode');
        
        return DataTable::of($builder)
                ->edit('jualTbsKode', function($row, $meta){
                    return getKategoriTbs($row->jualTbsKode);
                })
                ->edit('jualTanggal', function($row, $meta){
                    return to_local_date($row->jualTanggal);
                })
                ->filter(function ($builder, $request) {
                
                    if ($request->periode)
                        $builder->where('jualIndkKode', $request->periode);
            
                })->toJson(true);
    }

    public function simpan()
    {
        
        $periodeData = $this->GetPeriode('jualIndkKode');
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
        $periodeTanggal = $periodeData["indkPeriodeTahun"].'-'.($periodeData["indkPeriodeBulan"]<10?'0'.$periodeData["indkPeriodeBulan"]:$periodeData["indkPeriodeBulan"]).'-01';
        $rules = [
            'jualUraian' => ['label' => 'Uraian', 'rules' => 'required','errors'=>['required' => 'Kolom {field} wajib diisi!',]],
            'jualIsEkspor' => ['label' => 'Jenis Penjualan', 'rules' => 'required','errors'=>['required' => 'Kolom {field} wajib diisi!',]],
            'jualTbsKode' => ['label' => 'Jenis TBS', 'rules' => 'required','errors'=>['required' => 'Kolom {field} wajib diisi!',]],
            'jualHarga' => ['label' => 'Harga Satuan', 'rules' => 'required','errors'=>['required' => 'Kolom {field} wajib diisi!',]],
            'jualVolume' => ['label' => 'Volume', 'rules' => 'required','errors'=>['required' => 'Kolom {field} wajib diisi!',]],
        ];
        if ($this->request->getPost("kode")!=null)
            $rules['kode'] = ['label' => 'ID', 'rules' => 'required|is_natural'];
        if ($this->request->getPost("jualTanggal")!=null){
            $rules['jualTanggal'] = ['label' => 'Tanggal', 'rules' => 'valid_date|is_last_month['.$periodeTanggal.']','errors'=>['is_last_month' => 'Kolom {field} tidak valid, gunakan tanggal sebelum periode pelaporan!',]];
        }
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

        //format inputan
        $post = $this->request->getPost();
        $kode=$post["kode"];
        unset($post["kode"]);
        $file=$this->request->getFile('jualFile');
        if ($file && $file->isValid()){
            $upload = $this->DoUpload("jualFile");
            if ($upload["status"]) {
                $post['jualFile'] = $upload["filename"];
            } else {
                return $this->response->setJSON([
                            'simpan' => false,
                            'validasi' => true,
                            'pesan' => "Gagal mengupload, error : ".$upload["error"]
                        ]);
                        return; 
            }
        } else {
            unset($post["jualFile"]);
        }
        if ($this->request->getPost("jualTanggal")!=null){
            $post['jualTanggal'] = to_mysql_date($post['jualTanggal']);
        }
        
        $model = $this->model->find($kode);
        if ($model){
            $exist = $this->model->where($post)->first();
            if ($exist){
                if ($kode!=$exist['jualKode']){
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan' => "Gagal mengubah data. Periode sudah pernah dibuat!"
                    ]);
                    return; 
                }
            }
            //print_r($post["jualHarga"]);
            $post["jualHarga"] = toDecimal($post["jualHarga"]);
            //echo "<br>";
            //print_r($post["jualHarga"]);
            $post["jualVolume"] = toDecimal($post["jualVolume"]);
            
            $post["jualTotal"] = $post["jualHarga"] * $post["jualVolume"];
            //print_r($post);
            $this->model->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'post'=>$post,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
        
            
            $post["jualHarga"] = toDecimal($post["jualHarga"]);
            $post["jualVolume"] = toDecimal($post["jualVolume"]);
            $post["jualTotal"] = doubleval($post["jualHarga"]) * doubleval($post["jualVolume"]);
            
            $this->model->save($post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'post'=>$post,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
        
        
    }

    

    public function edit()
    {
        $rules = [
            'jualKode' => ['label' => 'ID', 'rules' => 'required|is_natural']
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
        
        $penjualanModel = new \App\Models\Pks\Penjualan_m();
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

        $penjualanModel = new \App\Models\Pks\Penjualan_m();
       
        $rekap = $penjualanModel->getRekap($this->request->getPost("periode"));
        $query = [
            "cpo_ekspor_total" => $rekap["cpo_ekspor_vol"] == 0 ? 0 : $rekap["cpo_ekspor"],
            "cpo_ekspor_vol"   => $rekap["cpo_ekspor_vol"],
            "cpo_ekspor_fob"   => safe_div($rekap["cpo_ekspor"], $rekap["cpo_ekspor_vol"]),

            "cpo_lokal_total"  => $rekap["cpo_lokal"],
            "cpo_lokal_vol"    => $rekap["cpo_lokal_vol"],
            "cpo_lokal_fob"    => safe_div($rekap["cpo_lokal"], $rekap["cpo_lokal_vol"]),

            "inti_ekspor_total" => safe_div($rekap["inti_ekspor"], $rekap["inti_ekspor_vol"]),
            "inti_ekspor_vol"   => $rekap["inti_ekspor_vol"],
            "inti_ekspor_fob"   => safe_div($rekap["inti_ekspor"], $rekap["inti_ekspor_vol"]),

            "inti_lokal_total" => $rekap["inti_lokal_vol"] == 0 ? 0 : $rekap["inti_lokal"],
            "inti_lokal_vol"   => $rekap["inti_lokal_vol"],
            "inti_lokal_fob"   => safe_div($rekap["inti_lokal"], $rekap["inti_lokal_vol"]),
        ];
        
        return $this->response->setJSON([
            'rekap' => true,
            'data' => $query
        ]);
    }

    

    
}
