<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Pengolahan extends BaseController
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
        
        $pengolahanModel = new \App\Models\Pks\Periode_m();
        
        $periode = $pengolahanModel->where('indkPksKode', $kode_pks)->findAll();
        $periodeCb = [];
        foreach ($periode as $row=>$val)
            $periodeCb[$val["indkKode"]]=bulan($val["indkPeriodeBulan"])." ".$val["indkPeriodeTahun"];

        $pengolahanKategoriModel = new \App\Models\Ref\KategoriPengolahan_m();
        $katPengolahan = $pengolahanKategoriModel->findAll();
        $katPengolahanCb = [];
        foreach ($katPengolahan as $row=>$val)
            $katPengolahanCb[$val["katolahNama"]][$val["katolahKode"]]=$val["katolahSubNama"];

        $data = [
            'title' => 'BERANDA',
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
                                olahKode'
                                )
                    ->join('ksmard_r_kat_pengolahan_pks', 'ksmard_r_kat_pengolahan_pks.katolahKode = ksmard_t_pengolahan_pks.olahKatolahKode');
                               
        return DataTable::of($builder)
                ->filter(function ($builder, $request) {
                
                    if ($request->periode)
                        $builder->where('olahIndkKode', $request->periode);
            
                })->toJson(true);
    }

    public function simpan()
    {
        helper("currency_helper");
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

        $pengolahanModel = new \App\Models\Pks\Pengolahan_m();

        $post = $this->request->getPost();
        $kode=$post["kode"];
        unset($post["kode"]);
        $model = $pengolahanModel->find($kode);
        if ($model){
            $exist = $pengolahanModel->where($post)->first();
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
            $pengolahanModel->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
        
            
            $post["olahTotal"] = toDecimal($post["olahTotal"]);
            
            $pengolahanModel->save($post);
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
        $pengolahanModel = new \App\Models\Pks\Pengolahan_m();

        $post = $this->request->getPost();
        unset($post["kode"]);
        $exist = $pengolahanModel->where($post)->first();
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
        
        $pengolahanModel = new \App\Models\Pks\Pengolahan_m();
        $periode = $pengolahanModel->find($id);
        if (!$periode){
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $periode = $pengolahanModel->delete($id);
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
