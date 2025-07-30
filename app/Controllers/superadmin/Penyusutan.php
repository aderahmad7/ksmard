<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class Penyusutan extends BaseController
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
            'title' => 'PENYUSUTAN',
        ];

        return view('superadmin/penyusutan/index', $data);
    }

    public function grid($menu = null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_r_kat_penyusutan_pks')
            ->select('katusutKode, katusutNama');

        return DataTable::of($builder)->toJson(true);
    }

    public function simpan()
    {
        $rules = [
            'katusutNama' => ['label' => 'Nama Kategori', 'rules' => 'required']
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

        $katusutModel = new \App\Models\Ref\KategoriPenyusutan_m();
        $post = $this->request->getPost();

        // Jika ada katusutKode berarti ini adalah update
        if (!empty($post['katusutKode'])) {
            // Update data
            $data = [
                'katusutNama' => $post['katusutNama']
            ];

            $katusutModel->update($post['katusutKode'], $data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
            // Insert data baru
            $data = [
                'katusutNama' => $post['katusutNama']
            ];
            $katusutModel->insert($data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
    }

    public function edit()
    {
        $katusutModel = new \App\Models\Ref\KategoriPenyusutan_m();
        $post = $this->request->getPost();
        $data = $katusutModel->where('katusutKode', $post['katusutKode'])->first();
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
        $id = $this->request->getPost("id"); // katusutKode

        $katusutModel = new \App\Models\Ref\KategoriPenyusutan_m();

        // Hapus data berdasarkan katusutKode
        $deleted = $katusutModel->where('katusutKode', $id)->delete();

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
