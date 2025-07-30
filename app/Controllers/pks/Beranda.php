<?php

namespace App\Controllers\Pks;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Beranda extends BaseController
{
    public function index()
    {
        $session = session();
        helper('form');
        helper("datetime_helper");
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'BERANDA'
        ];
        return view('pks/beranda/index', $data);
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
