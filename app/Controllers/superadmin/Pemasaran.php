<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class Pemasaran extends BaseController
{
    public function index()
    {
        $session = session();
        helper('form');
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'PEMASARAN',
        ];

        return view('superadmin/pemasaran/index', $data);
    }

    public function grid($menu = null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_r_kat_pemasaran_pks')
            ->select('katpsrKode, katpsrNama');

        return DataTable::of($builder)->toJson(true);
    }

    public function simpan()
    {
        $rules = [
            'katpsrNama' => ['label' => 'Nama Kategori', 'rules' => 'required']
        ];
        $validation = service('validation');
        $validation->setRules($rules);
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'simpan' => false,
                'validasi' => false,
                'pesan' => $validation->getErrors()
            ]);
        }

        $katpsrModel = new \App\Models\Ref\KategoriPemasaran_m();
        $post = $this->request->getPost();

        // Jika ada katpsrKode berarti ini adalah update
        if (!empty($post['katpsrKode'])) {
            // Update data
            $data = [
                'katpsrNama' => $post['katpsrNama']
            ];

            $katpsrModel->update($post['katpsrKode'], $data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
            // Insert data baru
            $data = [
                'katpsrNama' => $post['katpsrNama']
            ];
            $katpsrModel->insert($data);
            
            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
    }

    public function edit()
    {
        $katpsrModel = new \App\Models\Ref\KategoriPemasaran_m();
        $post = $this->request->getPost();
        $data = $katpsrModel->where('katpsrKode', $post['katpsrKode'])->first();
        if ($data) {
            return $this->response->setJSON([
                'edit' => true,
                'data' => $data
            ]);
        } else {
            return $this->response->setJSON([
                'edit' => false,
                'pesan' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function hapus()
    {
        $id = $this->request->getPost("id"); // katproKode

        $katpsrModel = new \App\Models\Ref\KategoriPemasaran_m();

        // Hapus data berdasarkan katpsrKode
        $deleted = $katpsrModel->where('katpsrKode', $id)->delete();

        if ($deleted) {
            return $this->response->setJSON([
                'hapus' => true,
                'pesan' => 'Berhasil menghapus data!'
            ]);
        } else {
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Gagal menghapus data. Silakan coba lagi.'
            ]);
        }
    }
}
