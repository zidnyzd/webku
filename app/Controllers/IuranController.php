<?php

namespace App\Controllers;

use App\Models\IuranModel;
use App\Models\IuranWargaModel;

class IuranController extends BaseController
{
    protected $iuranModel;
    protected $iuranWargaModel;

    public function __construct()
    {
        $this->iuranModel = new IuranModel();
        $this->iuranWargaModel = new IuranWargaModel();
    }

    // Menampilkan daftar iuran yang sudah ada
    public function iuranList()
    {
        // Pastikan user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/warga/login');
        }
        
        $role = session()->get('role');
        $id_user = session()->get('id_user');

        // Ambil semua iuran yang ada di database, dengan join untuk mendapatkan nominal_khusus jika ada
        $iuranList = $this->iuranModel
            ->select('iuran.*, iuran_warga.nominal_khusus')
            ->join('iuran_warga', 'iuran.id_iuran = iuran_warga.id_iuran AND iuran_warga.id_user = ' . $id_user, 'left')
            ->findAll();

        // Lakukan pengecekan apakah `nominal_khusus` tersedia, jika ya gunakan `nominal_khusus`, jika tidak `iuran_bulanan`
        foreach ($iuranList as &$iuran) {
            $iuran['jumlah_per_bulan'] = $iuran['nominal_khusus'] ?? $iuran['iuran_bulanan'];
        }

        $data = [
            'title' => 'Daftar Iuran',
            'iuranList' => $iuranList
        ];

        return view("{$role}/iuran_list", $data);
    }


    public function iuranDetail($id_iuran)
    {
        // Ambil detail iuran dari database berdasarkan id
        $iuran = $this->iuranModel->find($id_iuran);
        $role = session()->get('role');
        $id_user = session()->get('id_user');

        // Jika iuran tidak ditemukan, tampilkan halaman 404
        if (!$iuran) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Iuran tidak ditemukan');
        }

        // Ambil nominal_khusus untuk user yang sedang login di tabel iuran_warga (jika ada)
        $nominalKhususData = $this->iuranWargaModel
            ->select('nominal_khusus')
            ->where('id_user', $id_user)
            ->where('id_iuran', $id_iuran)  // Berdasarkan id iuran dan id user
            ->get()
            ->getRow();

        $nominalKhusus = $nominalKhususData ? $nominalKhususData->nominal_khusus : null;

        // Gunakan nominal khusus jika ada, jika tidak gunakan nilai default dari iuran
        $jumlahPerBulan = $nominalKhusus ?: $iuran['iuran_bulanan'];

        // Ambil semua warga yang sudah membayar iuran ini
        $iuranWarga = $this->iuranWargaModel
            ->select('iuran_warga.*, warga.nama_lengkap, warga.blok_no, warga.dawis, iuran_warga.nominal_khusus')  // Pilih kolom yang ingin ditampilkan
            ->join('warga', 'warga.id_user = iuran_warga.id_user')  // Join dengan tabel warga
            ->where('iuran_warga.id_iuran', $id_iuran)  // Berdasarkan id iuran
            ->findAll();

         // Cek apakah setiap warga memiliki nominal khusus, jika ada gunakan nominal tersebut, jika tidak gunakan `iuran_bulanan`
        foreach ($iuranWarga as &$warga) {
            $warga['jumlah_per_bulan'] = $warga['nominal_khusus'] ?? $iuran['iuran_bulanan'];
        }

        // Kirim data ke view
        $data = [
            'title' => 'Detail Iuran',
            'iuran' => $iuran,
            'iuranWarga' => $iuranWarga,
            'nominal_khusus' => $nominalKhusus,  // Tambahkan nominal_khusus ke data view
            'jumlah_per_bulan' => $jumlahPerBulan  // Tambahkan jumlah per bulan yang dipilih
        ];

        return view("{$role}/iuran_detail", $data);
    }

    public function index() 
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/warga/login');
        }

        $role = session()->get('role');
        $id_user = session()->get('id_user');

        $iuranWarga = $this->iuranWargaModel
            ->select('iuran_warga.*, iuran.nama_iuran, iuran.tahun, iuran.iuran_bulanan') 
            ->join('iuran', 'iuran.id_iuran = iuran_warga.id_iuran')
            ->where('iuran_warga.id_user', $id_user)
            ->findAll();

        $currentMonth = intval(date('m'));
        $totalIuranBelumDibayar = 0;
        $iuranDetails = [];

        foreach ($iuranWarga as &$iuran) {
            $totalSudahDibayar = 0;
            $totalHarusDibayar = 0;
            $allPaid = true;

            for ($i = 1; $i <= $currentMonth; $i++) {
                $namaBulan = strtolower(date('F', mktime(0, 0, 0, $i, 10)));

                switch ($namaBulan) {
                    case 'january': $namaBulan = 'januari'; break;
                    case 'february': $namaBulan = 'februari'; break;
                    case 'march': $namaBulan = 'maret'; break;
                    case 'april': $namaBulan = 'april'; break;
                    case 'may': $namaBulan = 'mei'; break;
                    case 'june': $namaBulan = 'juni'; break;
                    case 'july': $namaBulan = 'juli'; break;
                    case 'august': $namaBulan = 'agustus'; break;
                    case 'september': $namaBulan = 'september'; break;
                    case 'october': $namaBulan = 'oktober'; break;
                    case 'november': $namaBulan = 'november'; break;
                    case 'december': $namaBulan = 'desember'; break;
                }

                if (isset($iuran[$namaBulan]) && (float)$iuran[$namaBulan] > 0) {
                    $totalSudahDibayar += (float) $iuran[$namaBulan];
                }

                if (isset($iuran[$namaBulan]) && (float)$iuran[$namaBulan] == 0) {
                    $nilaiIuran = $iuran['nominal_khusus'] ?? $iuran['iuran_bulanan'];
                    $totalHarusDibayar += $nilaiIuran;
                    $allPaid = false;
                }
            }

            $iuranDetails[] = [
                'nama_iuran' => $iuran['nama_iuran'],
                'total_belum_dibayar' => $totalHarusDibayar,
                'total_sudah_dibayar' => $totalSudahDibayar
            ];

            $this->iuranWargaModel->update($iuran['id_iuran_warga'], [
                'total' => $totalSudahDibayar,
                'keterangan' => $allPaid ? 'Lunas' : 'Belum Lunas'
            ]);

            if (!$allPaid) {
                $totalIuranBelumDibayar += $totalHarusDibayar;
            }
        }

        return view("{$role}/iuran", [
            'title' => 'Iuran ' . ucfirst($role),
            'iuranWarga' => $iuranWarga,
            'totalIuran' => $totalIuranBelumDibayar,
            'iuranDetails' => $iuranDetails
        ]);
    }

    // Fungsi untuk mendapatkan nilai default iuran per bulan berdasarkan nama iuran
    private function getDefaultIuranValue($namaIuran)
    {
        // Ambil nilai default berdasarkan nama iuran
        $iuran = $this->iuranModel->where('nama_iuran', $namaIuran)->first();
    
        if ($iuran) {
            return $iuran['iuran_bulanan'];  // Mengambil nilai dari kolom iuran_bulanan
        }
        
        return 0; // Jika tidak ada nilai yang sesuai
    }
    

    public function createIuranForm()
    {
        $role = session()->get('role');
        if ($role !== 'bendahara' && $role !== 'ketua') {
            return redirect()->to('/warga/login');
        }
    
        // Tampilkan form untuk menambah iuran baru
        return view("{$role}/create_iuran", ['title' => 'Tambah Iuran Baru']);
    }
    
    public function store()
    {
        // Pastikan user adalah bendahara
        if (!in_array(session()->get('role'), ['bendahara', 'ketua'])) {
            return redirect()->to('/warga/login');
        }
    
        // Validasi input
        $validation = $this->validate([
            'nama_iuran' => 'required',
            'iuran_bulanan' => 'required|numeric',
            'tahun' => 'required|numeric|min_length[4]|max_length[4]'
        ]);
    
        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        // Simpan iuran baru ke database
        $iuranData = [
            'nama_iuran' => $this->request->getPost('nama_iuran'),
            'iuran_bulanan' => $this->request->getPost('iuran_bulanan'),
            'tahun' => $this->request->getPost('tahun')
        ];
    
        // Simpan dan cek apakah data berhasil disimpan
        if ($this->iuranModel->insert($iuranData)) {
            // Ambil ID iuran baru yang baru saja dimasukkan
            $id_iuran = $this->iuranModel->getInsertID();
    
            // Debug: Pastikan id_iuran baru benar
            if (!$id_iuran) {
                dd('Gagal mendapatkan ID Iuran yang baru. Insert Gagal');
            }
    
            // Ambil semua warga yang terdaftar
            $wargaModel = new \App\Models\WargaModel();
            $wargaList = $wargaModel->findAll();
    
            // Insert entri baru di iuran_warga dengan nilai 0 untuk tiap bulan untuk setiap warga
            foreach ($wargaList as $warga) {
                $dataInsert = [
                    'id_user' => $warga['id_user'],
                    'id_iuran' => $id_iuran,
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
                ];
    
                // Debug: Pastikan setiap warga dimasukkan ke iuran_warga
                if (!$this->iuranWargaModel->insert($dataInsert)) {
                    dd('Gagal memasukkan iuran_warga untuk user ID: ' . $warga['id_user']);
                }
            }
    
            // Redirect ke daftar iuran dengan pesan sukses
            return redirect()->to("/{$role}/iuran/list")->with('success', 'Iuran baru berhasil ditambahkan.');
        } else {
            dd('Gagal menyimpan data iuran.');
        }
    }

    public function edit($id_iuran)
    {
        // Pastikan user adalah bendahara atau ketua
        $role = session()->get('role');
        if ($role !== 'bendahara' && $role !== 'ketua') {
            return redirect()->to('/warga/login');
        }
    
        // Ambil data iuran berdasarkan id
        $iuran = $this->iuranModel->find($id_iuran);
    
        if (!$iuran) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Iuran tidak ditemukan');
        }
    
        // Tampilkan form edit dengan data iuran
        return view("{$role}/edit_iuran", [
            'title' => 'Edit Iuran',
            'iuran' => $iuran
        ]);
    }
    
    public function update($id_iuran)
    {
        // Pastikan user adalah bendahara atau ketua
        $role = session()->get('role');
        if ($role !== 'bendahara' && $role !== 'ketua') {
            return redirect()->to('/warga/login');
        }
    
        // Validasi input
        $validation = $this->validate([
            'nama_iuran' => 'required',
            'iuran_bulanan' => 'required|numeric',
            'tahun' => 'required|numeric|min_length[4]|max_length[4]'
        ]);
    
        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        // Update iuran di database
        $this->iuranModel->update($id_iuran, [
            'nama_iuran' => $this->request->getPost('nama_iuran'),
            'iuran_bulanan' => $this->request->getPost('iuran_bulanan'),
            'tahun' => $this->request->getPost('tahun')
        ]);
    
        // Redirect ke daftar iuran dengan pesan sukses
        return redirect()->to("/{$role}/iuran/list")->with('success', 'Iuran berhasil diperbarui.');

    }

    public function delete($id_iuran)
    {
        // Pastikan user adalah bendahara atau ketua
        $role = session()->get('role');
        if ($role !== 'bendahara' && $role !== 'ketua') {
            return redirect()->to('/warga/login');
        }
    
        // Hapus iuran dari database
        $this->iuranModel->delete($id_iuran);
    
        // Redirect ke daftar iuran dengan pesan sukses
        return redirect()->to("/{$role}/iuran/list")->with('success', 'Iuran berhasil dihapus.');
    }

    public function catatIuranForm($id_iuran_warga)
    {   
        // Ambil data iuran warga berdasarkan id_iuran_warga
        $iuranWarga = $this->iuranWargaModel
        ->select('iuran_warga.*, warga.nama_lengkap, warga.blok_no, warga.dawis')  // Join dengan tabel warga
        ->join('warga', 'warga.id_user = iuran_warga.id_user')  // Join dengan tabel warga
        ->where('id_iuran_warga', $id_iuran_warga)  // Berdasarkan id_iuran_warga
        ->first();

        // Pastikan user adalah bendahara atau ketua
        $role = session()->get('role');
        if ($role !== 'bendahara' && $role !== 'ketua') {
            return redirect()->to('/warga/login');
        }
    
        // Ambil data iuran warga berdasarkan id
        $iuranWarga = $this->iuranWargaModel->find($id_iuran_warga);
    
        if (!$iuranWarga) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Iuran Warga tidak ditemukan');
        }
    
        // Ambil data iuran yang terkait
        $iuran = $this->iuranModel->find($iuranWarga['id_iuran']);
    
        // Tampilkan form untuk mencatat pembayaran
        return view("{$role}/catat_iuran", [
            'title' => 'Catat Iuran Warga',
            'iuranWarga' => $iuranWarga,
            'iuran' => $iuran
        ]);
    }
    
    public function simpanIuran($id_iuran_warga)
    {
        if (session()->get('role') !== 'bendahara') {
            return redirect()->to('/login');
        }

        $validation = $this->validate([
            'bulan' => 'required',
            'jumlah' => 'required|numeric',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $bulan = $this->request->getPost('bulan');
        $jumlah = $this->request->getPost('jumlah');

        // Periksa apakah nominal_khusus tersedia
        $iuranWarga = $this->iuranWargaModel->find($id_iuran_warga);
        $nominalIuran = $iuranWarga['nominal_khusus'] ?? $this->getDefaultIuranValue($iuranWarga['id_iuran']);

        // Pastikan jumlah pembayaran sesuai dengan nominal iuran
        if ($jumlah != $nominalIuran) {
            return redirect()->back()->withInput()->with('error', 'Jumlah pembayaran harus sesuai dengan nominal iuran');
        }

        $this->iuranWargaModel->update($id_iuran_warga, [
            $bulan => $jumlah,
        ]);

        return redirect()->to("/{$role}/iuran/detail/" . $iuranWarga['id_iuran'])->with('success', 'Iuran berhasil dicatat.');
    }

    
    public function searchWarga()
    {
        $term = $this->request->getVar('term');
        $wargaModel = new \App\Models\WargaModel();
        $wargaList = $wargaModel->like('nama_lengkap', $term)->findAll();
    
        $results = [];
        foreach ($wargaList as $warga) {
            $results[] = [
                'label' => $warga['nama_lengkap'],
                'value' => $warga['id_user']
            ];
        }
    
        return $this->response->setJSON($results);
    }
    
}
