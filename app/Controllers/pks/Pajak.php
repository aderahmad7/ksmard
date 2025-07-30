<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Pajak extends BaseController
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
        
        $pajakMode = new \App\Models\Pks\Periode_m();
        $periode = $pajakMode->where('indkPksKode', $kode_pks)->findAll();
        $periodeCb = [];
        foreach ($periode as $row=>$val)
            $periodeCb[$val["indkKode"]]=bulan($val["indkPeriodeBulan"])." ".$val["indkPeriodeTahun"];
        $data = [
            'title' => 'BERANDA',
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
                                pjkKode'
                                );
        
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
        helper("currency_helper");
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

        $pajakMode = new \App\Models\Pks\Pajak_m();

        $post = $this->request->getPost();
        $kode=$post["kode"];
        unset($post["kode"]);
        $model = $pajakMode->find($kode);
        if ($model){
            $exist = $pajakMode->where($post)->first();
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
            $pajakMode->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
        
            
            $post["pjkTotal"] = toDecimal($post["pjkTotal"]);
            $post["pjkVolume"] = toDecimal($post["pjkVolume"]);
            $pajakMode->save($post);
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
        $pajakMode = new \App\Models\Pks\Pajak_m();

        $post = $this->request->getPost();
        unset($post["kode"]);
        $exist = $pajakMode->where($post)->first();
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
        
        $pajakMode = new \App\Models\Pks\Pajak_m();
        $periode = $pajakMode->find($id);
        if (!$periode){
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $periode = $pajakMode->delete($id);
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
