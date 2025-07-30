<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\ResponseInterface;

class BiayaTl extends BaseController
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
            'title' => 'BIAYA TIDAK LANGSUNG',
        ];

        return view('superadmin/biaya_tl/index', $data);
    }

    public function grid($menu = null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_r_kat_biayatl_pks')
            ->select('katbiayKode, katbiayNama');

        return DataTable::of($builder)->toJson(true);
    }

    public function simpan()
    {
        $rules = [
            'katbiayNama' => ['label' => 'Nama Kategori', 'rules' => 'required']
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

        $katbiayModel = new \App\Models\Ref\KategoriBiayaTL_m();
        $post = $this->request->getPost();

        // Jika ada katbiayKode berarti ini adalah update
        if (!empty($post['katbiayKode'])) {
            // Update data
            $data = [
                'katbiayNama' => $post['katbiayNama']
            ];

            $katbiayModel->update($post['katbiayKode'], $data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
            // Insert data baru
            $data = [
                'katbiayNama' => $post['katbiayNama']
            ];
            $katbiayModel->insert($data);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
    }

    public function edit()
    {
        $katbiayModel = new \App\Models\Ref\KategoriBiayaTL_m();
        $post = $this->request->getPost();
        $data = $katbiayModel->where('katbiayKode', $post['katbiayKode'])->first();
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
        $id = $this->request->getPost("id"); // katbiayKode

        $katbiayModel = new \App\Models\Ref\KategoriBiayaTL_m();

        // Hapus data berdasarkan katbiayKode
        $deleted = $katbiayModel->where('katbiayKode', $id)->delete();

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
