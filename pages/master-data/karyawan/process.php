<?php
require '../../../includes/function.php';
require '../../../includes/vendor/autoload.php';

// Ambil id_pengguna dari sesi atau cookie untuk pencatatan log aktivitas
$id_pengguna = $_SESSION['id_pengguna'] ?? $_COOKIE['ingat_user_id'] ?? '';

$table_name = 'karyawan';

if (isset($_POST['add'])) {
    $nama_karyawan = strtolower($_POST['nama_karyawan']);
    $jabatan = strtolower($_POST['jabatan']);
    $telepon = $_POST['telepon'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    
    if (!empty($telepon) && isValueExists($table_name, 'no_hp', $telepon)) {
        $_SESSION['error_message'] = "Nomor handphone sudah ada dalam database.";
        header("Location: index.php");
        exit();
    }
    
    // Generate UUID untuk kolom id_pengirim
    $id_karyawan = Ramsey\Uuid\Uuid::uuid4()->toString();

    // Data yang akan dimasukkan ke dalam tabel produk
    $data = [
        'id_karyawan' => $id_karyawan,
        'nama_karyawan' => $nama_karyawan,
        'id_jabatan' => $jabatan,
        'no_hp' => $telepon,
        'tanggal_masuk' => $tanggal_masuk
    ];

  // Panggil fungsi insertData untuk menambahkan data ke dalam tabel karyawan
  $result = insertData($table_name, $data);

  // Periksa apakah data berhasil ditambahkan
  if ($result > 0) {
      $_SESSION['success_message'] = "karyawan berhasil ditambahkan!";

      // Pencatatan log aktivitas
      $id_log = Ramsey\Uuid\Uuid::uuid4()->toString();
      $aktivitas = 'Berhasil tambah karyawan';
      $tabel = 'karyawan';
      $keterangan = 'Pengguna dengan ID ' . $id_pengguna . ' berhasil tambah karyawan dengan ID ' . $id_karyawan;
      $log_data = [
          'id_log' => $id_log,
          'id_pengguna' => $id_pengguna,
          'aktivitas' => $aktivitas,
          'tabel' => $tabel,
          'keterangan' => $keterangan
      ];
      insertData('log_aktivitas', $log_data);
  } else {
      $_SESSION['error_message'] = "Terjadi kesalahan saat menambahkan karyawan.";

      // Pencatatan log aktivitas
      $id_log = Ramsey\Uuid\Uuid::uuid4()->toString();
      $aktivitas = 'Gagal tambah karyawan';
      $tabel = 'karyawan';
      $keterangan = 'Pengguna dengan ID ' . $id_pengguna . ' gagal tambah karyawan ' . $kategori;
      $log_data = [
          'id_log' => $id_log,
          'id_pengguna' => $id_pengguna,
          'aktivitas' => $aktivitas,
          'tabel' => $tabel,
          'keterangan' => $keterangan
      ];
      insertData('log_aktivitas', $log_data);
  }

  header("Location: index.php");
  exit();
}elseif (isset($_POST['edit'])) {
  $id_karyawan = $_POST['id_karyawan'];
  $nama_karyawan = strtolower($_POST['nama_karyawan']);
  $jabatan = strtolower($_POST['jabatan']);
  $telepon = $_POST['telepon'];
  $tanggal_masuk = $_POST['tanggal_masuk'];

  if (!empty($telepon) && isValueExists($table_name, 'no_hp', $telepon, $id_karyawan, 'id_karyawan')) {
      $_SESSION['error_message'] = "Nomor handphone sudah ada dalam database.";
      header("Location: index.php");
      exit();
  }

  // Ambil data lama sebelum diubah
  $oldData = selectData('karyawan', 'id_karyawan = ?', '', '', [['type' => 's', 'value' => $id_karyawan]]);

  // Data yang akan diupdate di tabel
  $data = [
    'nama_karyawan' => $nama_karyawan,
    'id_jabatan' => $jabatan,
    'no_hp' => $telepon,
    'tanggal_masuk' => $tanggal_masuk
  ];

  // Kondisi untuk menentukan karyawan mana yang akan diupdate
  $conditions = "id_karyawan = '$id_karyawan'";
  // Panggil fungsi updateData untuk mengupdate data di tabel karyawan
  $result = updateData($table_name, $data, $conditions);

  // Periksa apakah data berhasil diupdate
  if ($result > 0) {
      $_SESSION['success_message'] = "karyawan berhasil diupdate!";

      // Ambil data setelah diubah
      $newData = selectData('karyawan', 'id_karyawan = ?', '', '', [['type' => 's', 'value' => $id_karyawan]]);

      // Data sebelum dan sesudah perubahan untuk log
      $before = $oldData[0]; // Ambil baris pertama dari hasil query
      $after = $newData[0]; // Ambil baris pertama dari hasil query

      // Keterangan perubahan
      $changeDescription = "Perubahan data karyawan: | ";

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
        'id_pengguna' => $id_pengguna, // pastikan ini sesuai dengan session atau cara penyimpanan ID pengguna di aplikasi kamu
        'aktivitas' => 'Ubah Data karyawan',
        'tabel' => 'karyawan',
        'keterangan' => $changeDescription,
      ];

      insertData('log_aktivitas', $logData);
  } else {
      $_SESSION['error_message'] = "Terjadi kesalahan saat mengupdate karyawan.";
  }

  header("Location: index.php");
  exit();
} else {
  // Jika tidak ada permintaan tambah atau edit, simpan pesan error ke dalam session
  $_SESSION['error_message'] = "Permintaan tidak valid!";
  header("Location: index.php");
  exit();
}

// Tutup koneksi ke database
mysqli_close($conn);
?>