<?php // master-data/user/process
require '../../includes/function.php';
require '../../includes/vendor/autoload.php';

// Ambil id_pengguna dari sesi atau cookie untuk pencatatan log aktivitas
$id_pengguna_log = $_SESSION['id_pengguna'] ?? $_COOKIE['ingat_user_id'] ?? '';

if (isset($_POST['add'])) {
  // Ambil nilai-nlai langsung dari $_POST
  $id_karyawan = $_POST['karyawan'];
  $nama_pengguna = strtolower($_POST['nama_pengguna']);
  $password = $_POST['password'];
  $confirm_password = $_POST["confirm_password"];
  $tipe_pengguna = $_POST['tipe_pengguna'];

  // Pastikan kedua password tidak kosong
  if (empty($password) || empty($confirm_password)) {
    // $register_error = "Password dan Ulangi Password harus diisi.";
    $_SESSION['error_message'] = "Password dan Ulangi Password harus diisi.";
    header("Location: index.php");
    exit();
  }

  // Periksa apakah password dan ulangi password cocok
  if ($password !== $confirm_password) {
      // Jika tidak cocok, kembalikan ke halaman registrasi dengan pesan kesalahan
      // $register_error = "Password dan Ulangi Password tidak cocok.";
      $_SESSION['error_message'] = "Password dan Ulangi Password tidak cocok.";
      header("Location: index.php");
      exit();
  }

  // Periksa apakah Nama pengguna sudah ada
  if (isValueExists('pengguna', 'nama_pengguna', $nama_pengguna)) {
    $_SESSION['error_message'] = "Nama pengguna sudah terdaftar.";
    header("Location: index.php");
    exit();
  }

  // Lakukan sanitasi pada input
  $nama_pengguna = sanitizeInput($nama_pengguna);
  $password = sanitizeInput($password);
  
  // Generate UUID untuk kolom id_pengguna
  $id_pengguna = Ramsey\Uuid\Uuid::uuid4()->toString();

  // Lakukan registrasi pengguna (Insert)
  $result = register($id_pengguna, $nama_pengguna, $password, $tipe_pengguna, $id_karyawan);

  // Periksa apakah data berhasil ditambahkan
  if ($result > 0) {
      // Jika berhasil, simpan pesan sukses ke dalam session
      $_SESSION['success_message'] = "Pengguna berhasil ditambahkan!";

      // Pencatatan log aktivitas
      $id_log = Ramsey\Uuid\Uuid::uuid4()->toString();
      $aktivitas = 'Berhasil tambah pengguna';
      $tabel = 'produk';
      $keterangan = 'Pengguna dengan ID ' . $id_pengguna_log . ' berhasil tambah pengguna dengan ID ' . $id_pengguna;
      $log_data = [
          'id_log' => $id_log,
          'id_pengguna' => $id_pengguna_log,
          'aktivitas' => $aktivitas,
          'tabel' => $tabel,
          'keterangan' => $keterangan
      ];
      insertData('log_aktivitas', $log_data);
  } else {
      // Jika gagal, simpan pesan error ke dalam session
      $_SESSION['error_message'] = "Terjadi kesalahan saat menambahkan pengguna.";
  }
} elseif (isset($_POST['edit'])) {
  // Ambil nilai-nilai dari form edit
  $id_pengguna = $_POST['id_pengguna'];
  $nama_pengguna = strtolower($_POST['nama_pengguna']);
  $password = $_POST['password'];
  $tipe_pengguna = $_POST['tipe_pengguna'];

  // Periksa apakah Username sudah ada (kecuali untuk pengguna yang sedang diedit)
  if (isValueExists('pengguna', 'nama_pengguna', $nama_pengguna, $id_pengguna, 'id_pengguna')) {
    $_SESSION['error_message'] = "Username sudah terdaftar.";
    header("Location: index.php");
    exit();
  }

  // Ambil data lama sebelum diubah
  $oldData = selectData('pengguna', 'id_pengguna = ?', '', '', [['type' => 's', 'value' => $id_pengguna]]);

  // Data yang akan diupdate di tabel pengguna
  $data = [
    'nama_pengguna' => $nama_pengguna,
    'password' => $password,
    'tipe_pengguna' => $tipe_pengguna
  ];

  // Kondisi untuk menentukan pengguna mana yang akan diupdate
  $conditions = "id_pengguna = '$id_pengguna'";

  // Panggil fungsi updateData untuk mengupdate data di tabel pengguna
  $result = updateData('pengguna', $data, $conditions);

  // Periksa apakah data berhasil diupdate
  if ($result > 0) {
      // Jika berhasil, simpan pesan sukses ke dalam session
      $_SESSION['success_message'] = "Pengguna berhasil diupdate!";

      // Ambil data setelah diubah
      $newData = selectData('pengguna', 'id_pengguna = ?', '', '', [['type' => 's', 'value' => $id_pengguna]]);

      // Data sebelum dan sesudah perubahan untuk log
      $before = $oldData[0]; // Ambil baris pertama dari hasil query
      $after = $newData[0]; // Ambil baris pertama dari hasil query

      // Keterangan perubahan
      $changeDescription = "Perubahan data pengguna: | ";

      // Nomor urut untuk tanda "-"
      $counter = 1;

      // Periksa setiap kolom untuk menemukan perubahan
      foreach ($before as $column => $value) {
          if ($value !== $after[$column]) {
              $changeDescription .= "$counter. $column: \"$value\" diubah menjadi \"$after[$column]\" | ";
              $counter++;
          }
      }
      
      // Catat aktivitas
      $id_log = Ramsey\Uuid\Uuid::uuid4()->toString();
      $logData = [
        'id_log' => $id_log,
        'id_pengguna' => $_SESSION['id_pengguna'], // pastikan ini sesuai dengan session atau cara penyimpanan ID pengguna di aplikasi kamu
        'aktivitas' => 'Ubah Data Pengguna',
        'tabel' => 'pengguna',
        'keterangan' => $changeDescription,
      ];

      insertData('log_aktivitas', $logData);
  } else {
      // Jika gagal, simpan pesan error ke dalam session
      $_SESSION['error_message'] = "Terjadi kesalahan saat mengupdate pengguna.";
  }
} else {
  // Jika tidak ada permintaan tambah atau edit, simpan pesan error ke dalam session
  $_SESSION['error_message'] = "Permintaan tidak valid!";
}

// Tutup koneksi ke database
mysqli_close($conn);

// Redirect kembali ke index.php setelah proses selesai
header("Location: index.php");
exit();