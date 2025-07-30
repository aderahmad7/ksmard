<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Pemasaran extends BaseController
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
        
        $pemasaranModel = new \App\Models\Pks\Periode_m();
        
        $periode = $pemasaranModel->where('indkPksKode', $kode_pks)->findAll();
        $periodeCb = [];
        foreach ($periode as $row=>$val)
            $periodeCb[$val["indkKode"]]=bulan($val["indkPeriodeBulan"])." ".$val["indkPeriodeTahun"];

        $pemasaranKategoriModel = new \App\Models\Ref\KategoriPemasaran_m();
        $katPemasaran = $pemasaranKategoriModel->findAll();
        $katPemasaranCb = [];
        foreach ($katPemasaran as $row=>$val)
            $katPemasaranCb[$val["katpsrKode"]]=$val["katpsrNama"];

        $data = [
            'title' => 'BERANDA',
            'periode'=>$periodeCb,
            'kategoriPemasaran'=>$katPemasaranCb,
        ];
        return view('pks/pemasaran/index', $data);
    }

    public function grid($menu=null)
    {
        $db = db_connect();
        helper("datetime_helper");
        helper("dropdown_helper");
        $builder = $db->table('ksmard_t_pemasaran_pks')
                    ->select('  psrKode,
                                psrUraian,
                                katpsrNama,
                                psrTbsKode,
                                psrIsEkspor,
                                psrTotal,
                                psrVolume,
                                psrKode'
                                )
                    ->join('ksmard_r_kat_pemasaran_pks', 'ksmard_r_kat_pemasaran_pks.katpsrKode = ksmard_t_pemasaran_pks.psrKatpsrKode');
                             
        return DataTable::of($builder)
                ->edit('psrTbsKode', function($row, $meta){
                    return getKategoriTbs($row->psrTbsKode);
                })
                ->filter(function ($builder, $request) {
                
                    if ($request->periode)
                        $builder->where('psrIndkKode', $request->periode);
            
                })->toJson(true);
    }

    public function simpan()
    {
        helper("currency_helper");
        $rules = [
            'psrUraian' => ['label' => 'Uraian', 'rules' => 'required'],
            'psrKatpsrKode' => ['label' => 'Kategori', 'rules' => 'required'],
            'psrIsEkspor' => ['label' => 'Jenis Penjualan', 'rules' => 'required'],
            'psrTbsKode' => ['label' => 'Jenis TBS', 'rules' => 'required'],
            'psrTotal' => ['label' => 'Total', 'rules' => 'required'],
            'psrVolume' => ['label' => 'Volume', 'rules' => 'required'],
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

        $pemasaranModel = new \App\Models\Pks\Pemasaran_m();

        $post = $this->request->getPost();
        $kode=$post["kode"];
        unset($post["kode"]);
        $model = $pemasaranModel->find($kode);
        if ($model){
            $exist = $pemasaranModel->where($post)->first();
            if ($exist){
                if ($kode!=$exist['psrKode']){
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan' => "Gagal mengubah data. Periode sudah pernah dibuat!"
                    ]);
                    return; 
                }
            }
            $post["psrTotal"] = toDecimal($post["psrTotal"]);
            $post["psrVolume"] = toDecimal($post["psrVolume"]);
            $pemasaranModel->update($kode, $post);
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
        
            
            $post["psrTotal"] = toDecimal($post["psrTotal"]);
            $post["psrVolume"] = toDecimal($post["psrVolume"]);
            
            $pemasaranModel->save($post);
           
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
            'psrKode' => ['label' => 'ID', 'rules' => 'required|is_natural']
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
        $pemasaranModel = new \App\Models\Pks\Pemasaran_m();

        $post = $this->request->getPost();
        unset($post["kode"]);
        $exist = $pemasaranModel->where($post)->first();
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
        
        $pemasaranModel = new \App\Models\Pks\Pemasaran_m();
        $periode = $pemasaranModel->find($id);
        if (!$periode){
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Data tidak ditemukan!'
            ]);
        }

        $periode = $pemasaranModel->delete($id);
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
