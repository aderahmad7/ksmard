<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Penjualan extends BaseController
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

        $kode_pks = $session->get('kodePKS');
        
        $penjualanModel = new \App\Models\Pks\Periode_m();
        $periode = $penjualanModel->where('indkPksKode', $kode_pks)->findAll();
        $periodeCb = [];
        foreach ($periode as $row=>$val)
            $periodeCb[$val["indkKode"]]=bulan($val["indkPeriodeBulan"])." ".$val["indkPeriodeTahun"];
        $data = [
            'title' => 'BERANDA',
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
                                jualNoKontrak,
                                jualPembeli,
                                jualKode'
                                );
        
        return DataTable::of($builder)
                ->edit('jualTbsKode', function($row, $meta){
                    return getKategoriTbs($row->jualTbsKode);
                })
                ->filter(function ($builder, $request) {
                
                    if ($request->periode)
                        $builder->where('jualIndkKode', $request->periode);
            
                })->toJson(true);
    }

    public function simpan()
    {
        helper("currency_helper");
        $rules = [
            'jualUraian' => ['label' => 'Uraian', 'rules' => 'required'],
            'jualIsEkspor' => ['label' => 'Jenis Penjualan', 'rules' => 'required'],
            'jualTbsKode' => ['label' => 'Jenis TBS', 'rules' => 'required'],
            'jualHarga' => ['label' => 'Harga Satuan', 'rules' => 'required'],
            'jualVolume' => ['label' => 'Volume', 'rules' => 'required'],
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

        $penjualanModel = new \App\Models\Pks\Penjualan_m();

        $post = $this->request->getPost();
        $kode=$post["kode"];
        unset($post["kode"]);
        $model = $penjualanModel->find($kode);
        if ($model){
            $exist = $penjualanModel->where($post)->first();
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
            $penjualanModel->update($kode, $post);
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
            
            $penjualanModel->save($post);
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
        $penjualanModel = new \App\Models\Pks\Penjualan_m();

        $post = $this->request->getPost();
        unset($post["kode"]);
        $exist = $penjualanModel->where($post)->first();
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
        $periode = $penjualanModel->find($id);
        if (!$periode){
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $periode = $penjualanModel->delete($id);
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
