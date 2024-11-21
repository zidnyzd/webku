<?php

namespace App\Controllers;

use App\Models\WargaModel;
use App\Models\IuranWargaModel;
use App\Models\IuranModel;

class PengurusController extends BaseController
{
    protected $wargaModel;
    protected $iuranWargaModel;
    protected $iuranModel;

    public function __construct()
    {
        $this->wargaModel = new WargaModel();
        $this->iuranWargaModel = new IuranWargaModel();
        $this->iuranModel = new IuranModel();
    }
    
    // Daftar warga dengan search
    public function wargaList()
    {
        // Pastikan user adalah pengurus
        if (session()->get('role') !== 'pengurus') {
            return redirect()->to('/warga/login');
        }
        
        $keyword = $this->request->getGet('keyword');
        if ($keyword) {
            $wargaList = $this->wargaModel->like('nama_lengkap', $keyword)
                                           ->orLike('nik', $keyword)
                                           ->orLike('no_kk', $keyword)
                                           ->findAll();
        } else {
            $wargaList = $this->wargaModel->findAll();
        }

        return view('pengurus/catat_iuran_warga', ['wargaList' => $wargaList, 'title' => 'Daftar Warga']);
    }

    // Form create warga baru
    public function create()
    {
        return view('pengurus/create_warga', ['title' => 'Tambah Warga Baru']);
    }

    // Proses tambah warga baru
    public function store()
    {
        $validation = $this->validate([
            'nik' => 'required|min_length[16]|max_length[16]|is_unique[warga.nik]',
            'nama_lengkap' => 'required',
            'no_kk' => 'required|min_length[16]|max_length[16]',
            'alamat' => 'required',
            'blok_no' => 'required',
            'dawis' => 'required',
            'no_telpon' => 'required|max_length[15]',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'status_pernikahan' => 'required',
            'agama' => 'required',
            'status_anggota_keluarga' => 'required',
            'kewarganegaraan' => 'required',
            'pekerjaan' => 'required',
            'password' => 'required'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->wargaModel->save([
            'nik' => $this->request->getPost('nik'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'no_kk' => $this->request->getPost('no_kk'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'alamat' => $this->request->getPost('alamat'),
            'blok_no' => $this->request->getPost('blok_no'),
            'dawis' => $this->request->getPost('dawis'),
            'no_telpon' => $this->request->getPost('no_telpon'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'agama' => $this->request->getPost('agama'),
            'status_anggota_keluarga' => $this->request->getPost('status_anggota_keluarga'),
            'kewarganegaraan' => $this->request->getPost('kewarganegaraan'),
            'pekerjaan' => $this->request->getPost('pekerjaan'),
            'role' => 'warga'
        ]);

        // Ambil ID warga baru yang baru saja dimasukkan
        $id_user = $this->wargaModel->getInsertID();

        // Ambil semua iuran yang tersedia
        $iuranList = $this->iuranModel->findAll();

        // Buat entri di tabel iuran_warga untuk warga baru
        foreach ($iuranList as $iuran) {
            $this->iuranWargaModel->insert([
                'id_user' => $id_user,
                'id_iuran' => $iuran['id_iuran'],
                'januari' => 0,
                'februari' => 0,
                'maret' => 0,
                'april' => 0,
                'mei' => 0,
                'juni' => 0,
                'juli' => 0,
                'agustus' => 0,
                'september' => 0,
                'oktober' => 0,
                'november' => 0,
                'desember' => 0,
                'total' => 0,
                'keterangan' => 'Belum Lunas'
            ]);
        }

        return redirect()->to('/pengurus/warga')->with('success', 'Data warga berhasil ditambahkan.');
    }

    // Form edit warga
    public function edit($id_user)
    {
        $warga = $this->wargaModel->find($id_user);

        if (!$warga) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Warga tidak ditemukan');
        }

        return view('pengurus/edit_warga', ['warga' => $warga, 'title' => 'Edit Warga']);
    }

    // Proses update warga
    public function update($id_user)
    {
        $validation = $this->validate([
            'nik' => "required|min_length[16]|max_length[16]|is_unique[warga.nik,id_user,{$id_user}]",
            'nama_lengkap' => 'required',
            'no_kk' => 'required|min_length[16]|max_length[16]',
            'alamat' => 'required',
            'blok_no' => 'required',
            'dawis' => 'required',
            'no_telpon' => 'required|max_length[15]',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'status_pernikahan' => 'required',
            'agama' => 'required',
            'status_anggota_keluarga' => 'required',
            'kewarganegaraan' => 'required',
            'pekerjaan' => 'required'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->wargaModel->update($id_user, [
            'nik' => $this->request->getPost('nik'),
            'no_kk' => $this->request->getPost('no_kk'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'alamat' => $this->request->getPost('alamat'),
            'blok_no' => $this->request->getPost('blok_no'),
            'dawis' => $this->request->getPost('dawis'),
            'no_telpon' => $this->request->getPost('no_telpon'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'status_pernikahan' => $this->request->getPost('status_pernikahan'),
            'agama' => $this->request->getPost('agama'),
            'status_anggota_keluarga' => $this->request->getPost('status_anggota_keluarga'),
            'kewarganegaraan' => $this->request->getPost('kewarganegaraan'),
            'pekerjaan' => $this->request->getPost('pekerjaan')
        ]);

        return redirect()->to('/pengurus/warga')->with('success', 'Data warga berhasil diperbarui.');
    }

    // Hapus warga
    public function deleteWarga($id_user)
    {
        if ($this->wargaModel->delete($id_user)) {
            $this->iuranWargaModel->where('id_user', $id_user)->delete();
            return redirect()->to('/pengurus/warga')->with('success', 'Warga berhasil dihapus.');
        } else {
            return redirect()->to('/pengurus/warga')->with('error', 'Gagal menghapus warga.');
        }
    }

    public function manageNominalKhusus()
    {
        $keyword = $this->request->getGet('keyword');
        $wargaList = $this->wargaModel;

        if ($keyword) {
            $wargaList = $wargaList->like('nik', $keyword)
                                ->orLike('nama_lengkap', $keyword)
                                ->orLike('no_kk', $keyword);
        }

        $wargaList = $wargaList->findAll();

        foreach ($wargaList as &$warga) {
            $warga['iuran_list'] = $this->iuranWargaModel
                ->select('iuran.nama_iuran, iuran.iuran_bulanan as nominal_default, iuran_warga.nominal_khusus, iuran.id_iuran')
                ->join('iuran', 'iuran_warga.id_iuran = iuran.id_iuran')
                ->where('iuran_warga.id_user', $warga['id_user'])
                ->findAll();
        }

        return view('pengurus/manage_nominal_khusus', [
            'title' => 'Kelola Nominal Khusus Warga',
            'wargaList' => $wargaList
        ]);
    }


    public function editNominalKhusus($id_user)
    {
        // Ambil data warga berdasarkan ID
        $warga = $this->wargaModel->find($id_user);
        if (!$warga) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Warga tidak ditemukan');
        }

        // Ambil daftar iuran dan nominal khusus untuk pengguna
        $iuranList = $this->iuranWargaModel
            ->select('iuran.nama_iuran, iuran.iuran_bulanan as nominal_default, iuran_warga.nominal_khusus, iuran.id_iuran')
            ->join('iuran', 'iuran_warga.id_iuran = iuran.id_iuran')
            ->where('iuran_warga.id_user', $id_user)
            ->findAll();

        // Kirim data ke view
        return view('pengurus/edit_nominal_khusus', [
            'title' => 'Edit Nominal Khusus - ' . esc($warga['nama_lengkap']),
            'warga' => $warga,
            'iuranList' => $iuranList
        ]);
    }

    public function updateNominalKhusus($id_user, $id_iuran)
    {
        $nominalKhususRaw = $this->request->getPost('nominal_khusus_raw');
        
        // Set nominal khusus to null only if empty, otherwise, set the numeric value
        $nominalKhusus = !empty($nominalKhususRaw) ? (int)str_replace('.', '', $nominalKhususRaw) : null;
    
        $this->iuranWargaModel->where('id_user', $id_user)
                              ->where('id_iuran', $id_iuran)
                              ->set(['nominal_khusus' => $nominalKhusus])
                              ->update();
    
        return redirect()->to('/pengurus/manage_nominal_khusus')->with('success', 'Nominal Khusus berhasil diperbarui.');
    }

    // Kelola iuran dan catat pembayaran
    public function catatIuran($id_user)
    {
        $warga = $this->wargaModel->find($id_user);
        if (!$warga) {
            return redirect()->to('/pengurus/warga')->with('error', 'Warga tidak ditemukan.');
        }

        $iuranList = $this->iuranModel->findAll();
        $iuranPribadi = $this->iuranWargaModel
            ->select('iuran_warga.*, iuran.nama_iuran, iuran.tahun')
            ->join('iuran', 'iuran.id_iuran = iuran_warga.id_iuran')
            ->where('id_user', $id_user)
            ->findAll();

        return view('pengurus/catat_iuran', [
            'title' => 'Catat Iuran Warga',
            'warga' => $warga,
            'iuranList' => $iuranList,
            'iuranPribadi' => $iuranPribadi
        ]);
    }

}
