<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class Produksi extends BaseController
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
            'title' => 'PRODUKSI',
        ];

        return view('superadmin/produksi/index', $data);
    }

    public function grid($menu = null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_r_kat_produksi')
            ->select('katproKode, katproNama');

        return DataTable::of($builder)->toJson(true);
    }

    public function simpan()
    {
        $rules = [
            'katproNama' => ['label' => 'Nama Kategori', 'rules' => 'required']
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

        $katproModel = new \App\Models\Ref\KategoriProduksiM();
        $post = $this->request->getPost();

        // Jika ada katproKode berarti ini adalah update
        if (!empty($post['katproKode'])) {
            // Update data
            $data = [
                'katproNama' => $post['katproNama']
            ];

            $katproModel->update($post['katproKode'], $data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
            // Insert data baru
            $data = [
                'katproNama' => $post['katproNama']
            ];

            $katproModel->insert($data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
    }

    public function edit()
    {
        $katproModel = new \App\Models\Ref\KategoriProduksiM();
        $post = $this->request->getPost();
        $data = $katproModel->where('katproKode', $post['katproKode'])->first();
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

        $katproModel = new \App\Models\Ref\KategoriProduksiM();

        // Hapus data berdasarkan katproKode
        $deleted = $katproModel->where('katproKode', $id)->delete();

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
