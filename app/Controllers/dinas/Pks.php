<?php

namespace App\Controllers\dinas;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Pks extends BaseController
{
    public function index()
    {
        $session = session();
        helper('form');
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        log_message('info', print_r($session->get('kodeDinas'), true));

        $data = [
            'title' => 'BERANDA'
        ];

        return view('dinas/pks/index', $data);
    }

    public function grid($menu = null)
    {
        $session = session();
        $kodeDinas = $session->get('kodeDinas');
        $db = db_connect();
        helper("datetime_helper");

        $builder = $db->table('ksmard_t_role AS r') // Gunakan alias dengan AS
            ->join('ksmard_t_account AS a', 'a.accUsername = r.roleAccUsername')
            ->select('
            a.accUsername,
            a.accNama,
            a.accEmail,
            a.accNoWhatsapp,
            r.roleKodePKS,
            r.roleKodeDinas,
        ')->where('r.roleKodeDinas', $kodeDinas)->where('r.roleRole', 'pks');

        return DataTable::of($builder)->toJson(true);
    }


    public function simpan()
    {
        $rules = [
            'pks' => ['label' => 'Kode', 'rules' => 'required'],
            'accUsername' => ['label' => 'Username', 'rules' => 'required'],
            'accNama' => ['label' => 'Nama', 'rules' => 'required'],
            'accPassword' => ['label' => 'Password', 'rules' => 'required']
        ];
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


        $accountModel = new \App\Models\User_m();
        $roleModel = new \App\Models\Superadmin\Role_m();
        $pksModel = new \App\Models\Dinas\Pks_m();

        $post = $this->request->getPost();

        $session = session();
        $kodedinas = $session->get('kodeDinas');

        $kode = $post["kode"];
        $kodepks = $post["pksKode"];
        $kodepksinput = $post["pks"];
        unset($post["kode"]);
        unset($post["pksKode"]);
        unset($post["pks"]);
        $model = $accountModel->find($kode);
        if ($model) {
            $exist = $accountModel->where($post)->first();
            if ($exist) {
                if ($kode != $exist['accUsername']) {
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => false,
                        'pesan' => 'Data sudah ada'
                    ]);
                    return;
                }
            }

            // Cek jika username sudah ada
            if ($post['accUsername'] != $kode) {
                if ($accountModel->find($post['accUsername'])) {
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan'  => 'Username sudah digunakan.',
                    ]);
                }
            }

            // Cek jika dinKode sudah ada
            if ($kodepksinput != $kodepks) {
                if ($pksModel->find($kodepksinput)) {
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan'  => 'Kode Pks sudah ada.',
                    ]);
                }
            }

            $accountModel->update($kode, $post);
            $roleModel->update($kode, ['roleKodePKS' => $kodepksinput, 'roleAccUsername' => $post["accUsername"]]);
            $pksModel->update($kodepks, ['pksKode' => $kodepksinput, 'pksNama' => $post['accNama'], 'pksDinasKode' => $kodedinas]);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
            log_message('debug', 'masuk else');
            $db = \Config\Database::connect();

            $db->transStart();

            if ($accountModel->find($post["accUsername"])) {
                return $this->response->setJSON([
                    'simpan' => false,
                    'validasi' => true,
                    'pesan'  => 'Username sudah digunakan.',
                ]);
            }

            // Cek jika dinKode sudah ada
            if ($pksModel->find($kodepksinput)) {
                return $this->response->setJSON([
                    'simpan' => false,
                    'validasi' => true,
                    'pesan'  => 'Kode Pks sudah ada.',
                ]);
            }

            $accountModel->insert([
                'accUsername' => $post["accUsername"],
                'accPassword' => $post["accPassword"],
                'accNama' => $post["accNama"],
            ]);

            $pksModel->insert([
                'pksKode' => $kodepksinput,
                'pksNama' => $post["accNama"],
                'pksDinasKode' => $kodedinas,
            ]);

            $roleModel->insert([
                'roleAccUsername' => $post["accUsername"],
                'roleRole' => "pks",
                'roleKodePKS' => $kodepksinput,
                'roleKodeDinas' => $kodedinas
            ]);

            $db->transComplete();

            if (!$db->transStatus()) {
                return $this->response->setJSON([
                    'simpan' => false,
                    'validasi' => false,
                    'pesan' => 'Gagal menambahkan data!'
                ]);
            }

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> menambahkan data!'
            ]);
        }
    }

    public function edit()
    {
        $roleModel = new \App\Models\Superadmin\Role_m();

        $post = $this->request->getPost();
        $exist = $roleModel->select('ksmard_t_account.*, ksmard_m_pks.*')
            ->join('ksmard_t_account', 'ksmard_t_account.accUsername = ksmard_t_role.roleAccUsername', 'left')
            ->join('ksmard_m_pks', 'ksmard_m_pks.pksKode = ksmard_t_role.roleKodePKS', 'left')->where('ksmard_t_role.roleAccUsername', $post['accUsername'])
            ->first();

        if ($exist) {
            return $this->response->setJSON([
                'edit' => true,
                'data' => $exist
            ]);
        }
    }

    public function hapus()
    {
        $id = $this->request->getPost("id"); // accUsername
        $id_pks = $this->request->getPost("id_pks"); // dinKode


        $accountModel = new \App\Models\User_m();
        $roleModel = new \App\Models\Superadmin\Role_m();
        $pksModel = new \App\Models\Dinas\Pks_m();

        $db = \Config\Database::connect();
        $db->transStart();

        // Hapus data dari tabel role
        $deletedRole = $roleModel->where('roleAccUsername', $id)->delete();

        // Hapus data dari tabel dinas
        $deletedDinas = $pksModel->where('pksKode', $id_pks)->delete();

        // Hapus data dari tabel account
        $deletedAccount = $accountModel->where('accUsername', $id)->delete();

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'hapus' => false,
                'pesan' => 'Gagal menghapus data. Silakan coba lagi.'
            ]);
        }

        return $this->response->setJSON([
            'hapus' => true,
            'pesan' => 'Berhasil menghapus data!'
        ]);
    }
}
