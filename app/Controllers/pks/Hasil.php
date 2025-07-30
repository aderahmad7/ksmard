<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Hasil extends BaseController
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
        $produksiModel = new \App\Models\Pks\Periode_m();
        $periode = $produksiModel->where('indkPksKode', 'ABS')->findAll();
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
                                hasilVolume'
                                );
        
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

        $produksiModel = new \App\Models\Pks\ProduksiHasil_m();

        $post = $this->request->getPost();
        $kode=$post["kodehasil"];
        unset($post["kodehasil"]);
        $model = $produksiModel->find($kode);
        if ($model){
            $exist = $produksiModel->where($post)->first();
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
            
            $produksiModel->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
        
            
            $post["hasilVolume"] = toDecimal($post["hasilVolume"]);
            
            $produksiModel->save($post);
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
        $exist = $produksiModel->where($post)->first();
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
        
        $produksiModel = new \App\Models\Pks\ProduksiHasil_m();
        $periode = $produksiModel->find($id);
        if (!$periode){
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $periode = $produksiModel->delete($id);
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
