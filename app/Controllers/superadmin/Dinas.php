<?php

namespace App\Controllers\superadmin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use \Hermawan\DataTables\DataTable;

class Dinas extends BaseController
{
    public function index()
    {
        $session = session();
        helper('form');
        if (!$session->get('cekLogin')) {
            // If not logged in, redirect to login page
            return redirect()->to('/login');
        }

        $provinsi = [
            'KALSEL' => 'Kalimantan Selatan',
            'KALUT' => 'Kalimantan Utara',
            'KALBAR' => 'Kalimantan Barat',
            'KALTIM' => 'Kalimantan Timur',
            'KALTENG' => 'Kalimantan Tengah',
        ];

        $options = [];

        foreach ($provinsi as $kode => $nama) {
            // Ubah menjadi string JSON sebagai key (value di <option>)
            $value = json_encode(['dinKode' => $kode, 'dinProvinsi' => $nama]);
            $options[$value] = $nama; // Tampilkan hanya nama provinsi
        }

        $data = [
            'title' => 'DINAS',
            'provinsi' => $options
        ];

        return view('superadmin/dinas/index', $data);
    }

    public function grid($menu = null)
    {
        $db = db_connect();
        helper("datetime_helper");
        $builder = $db->table('ksmard_t_role r')
            ->join('ksmard_t_account a', 'a.accUsername = r.roleAccUsername')
            ->join('ksmard_m_dinas d', 'd.dinKode = r.roleKodeDinas')
            ->select('
            a.accUsername,
            a.accNama,
            a.accEmail,
            a.accNoWhatsapp,
            r.roleKodeDinas,
            d.dinProvinsi
        ')
            ->where('r.roleRole', 'dinas');

        return DataTable::of($builder)->toJson(true);
    }

    public function simpan()
    {
        $kode = $this->request->getPost('kode');
        $accountModel = new \App\Models\User_m();

        $model = $accountModel->find($kode);

        $rules = [
            'accUsername' => ['label' => 'Username', 'rules' => 'required'],
            'accNama' => ['label' => 'Nama', 'rules' => 'required'],
        ];

        if (!$model) {
            $rules['accPassword'] = ['label' => 'Password', 'rules' => 'required'];
        }

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


        $roleModel = new \App\Models\Superadmin\Role_m();
        $dinasModel = new \App\Models\Superadmin\Dinas_m();

        $post = $this->request->getPost();

        $dinInfo = json_decode($post['dinKode'], true);

        $kodedinas = $post["kodedinas"];

        unset($post["kode"]);
        unset($post["dinKode"]);
        unset($post["kodedinas"]);
        if ($model) {
            $post["accPassword"] = $model["accPassword"];
            
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
            if ($dinInfo['dinKode'] != $kodedinas) {
                if ($dinasModel->find($dinInfo['dinKode'])) {
                    return $this->response->setJSON([
                        'simpan' => false,
                        'validasi' => true,
                        'pesan'  => 'Dinas provinsi ' . $dinInfo['dinProvinsi'] . ' sudah ada.',
                    ]);
                }
            }

            $accountModel->update($kode, $post);
            $roleModel->update($kode, ['roleKodeDinas' => $dinInfo['dinKode'], 'roleAccUsername' => $post["accUsername"]]);
            $dinasModel->update($kodedinas, ['dinProvinsi' => $dinInfo['dinProvinsi'], 'dinNama' => $post["accNama"], 'dinKode' => $dinInfo['dinKode']]);

            return $this->response->setJSON([
                'simpan' => true,
                'validasi' => true,
                'pesan' => '<b>Berhasil</b> mengubah data!'
            ]);
        } else {
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
            if ($dinasModel->find($dinInfo['dinKode'])) {
                return $this->response->setJSON([
                    'simpan' => false,
                    'validasi' => true,
                    'pesan'  => 'Dinas provinsi ' . $dinInfo['dinProvinsi'] . ' sudah ada.',
                ]);
            }

            $accountModel->insert([
                'accUsername' => $post["accUsername"],
                'accPassword' => password_hash($post["accPassword"], PASSWORD_DEFAULT),
                'accNama' => $post["accNama"],
            ]);



            $dinasModel->insert([
                'dinKode' => $dinInfo['dinKode'],
                'dinNama' => $post["accNama"],
                'dinProvinsi' => $dinInfo['dinProvinsi'],

            ]);

            $roleModel->insert([
                'roleAccUsername' => $post["accUsername"],
                'roleRole' => "dinas",
                'roleKodeDinas' => $dinInfo['dinKode'],
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
        $exist = $roleModel->select('ksmard_t_account.*, ksmard_m_dinas.*')
            ->join('ksmard_t_account', 'ksmard_t_account.accUsername = ksmard_t_role.roleAccUsername', 'left')
            ->join('ksmard_m_dinas', 'ksmard_m_dinas.dinKode = ksmard_t_role.roleKodeDinas', 'left')->where('ksmard_t_role.roleAccUsername', $post['accUsername'])
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
        $id_dinas = $this->request->getPost("id_dinas"); // dinKode

        $accountModel = new \App\Models\User_m();
        $roleModel = new \App\Models\Superadmin\Role_m();
        $dinasModel = new \App\Models\Superadmin\Dinas_m();

        $db = \Config\Database::connect();
        $db->transStart();

        // Hapus data dari tabel role
        $deletedRole = $roleModel->where('roleAccUsername', $id)->delete();

        // Hapus data dari tabel dinas
        $deletedDinas = $dinasModel->where('dinKode', $id_dinas)->delete();

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
