<?php
require '../../includes/function.php';
require '../../includes/vendor/autoload.php';

// Ambil id_pengguna dari sesi atau cookie untuk pencatatan log aktivitas
$id_pengguna = $_SESSION['id_pengguna'] ?? $_COOKIE['ingat_user_id'] ?? '';

$table_name = 'pengajuan_lembur';

if (isset($_POST['add'])) {
  $tanggal_pengajuan = $_POST['tanggal_pengajuan'];
  $waktu_mulai = $_POST['waktu_mulai'];
  $waktu_selesai = $_POST['waktu_selesai'];
  $keterangan = $_POST['alasan'];
  $id_karyawan = $_POST['id_karyawan'];
    
  $id_pengajuan = Ramsey\Uuid\Uuid::uuid4()->toString();

  // Data yang akan dimasukkan ke dalam tabel produk
  $data = [
      'id_pengajuan' => $id_pengajuan,
      'tanggal_pengajuan' => $tanggal_pengajuan,
      'waktu_mulai' => $waktu_mulai,
      'waktu_selesai' => $waktu_selesai,
      'keterangan' => $keterangan,
      'id_karyawan' => $id_karyawan
  ];

  // Panggil fungsi insertData untuk menambahkan data ke dalam tabel kontak
  $result = insertData($table_name, $data);

  // Periksa apakah data berhasil ditambahkan
  if ($result > 0) {
      $_SESSION['success_message'] = "pengajuan lembur berhasil dibuat!";

      // Pencatatan log aktivitas
      $id_log = Ramsey\Uuid\Uuid::uuid4()->toString();
      $aktivitas = 'Berhasil tambah pengajuan lembur';
      $tabel = 'pengajuan lembur';
      $keterangan = 'Pengguna dengan ID ' . $id_pengguna . ' berhasil membuat pengajuan lembur dengan ID ' . $id_karyawan;
      $log_data = [
          'id_log' => $id_log,
          'id_pengguna' => $id_pengguna,
          'aktivitas' => $aktivitas,
          'tabel' => $tabel,
          'keterangan' => $keterangan
      ];
      insertData('log_aktivitas', $log_data);
  } else {
      $_SESSION['error_message'] = "Terjadi kesalahan saat membuat pengajuan lembur.";

      // Pencatatan log aktivitas
      $id_log = Ramsey\Uuid\Uuid::uuid4()->toString();
      $aktivitas = 'Gagal tambah kontak';
      $tabel = 'kontak';
      $keterangan = 'Pengguna dengan ID ' . $id_pengguna . ' gagal membuat pengajuan lembur ' . $kategori;
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
  $id_pengajuan = $_POST['id_pengajuan'];
  $tanggal_pengajuan = $_POST['tanggal_pengajuan'];
  $waktu_mulai = $_POST['waktu_mulai'];
  $waktu_selesai = $_POST['waktu_selesai'];
  $keterangan = $_POST['alasan'];

  // Ambil data lama sebelum diubah
  $oldData = selectData('pengajuan_lembur', 'id_pengajuan = ?', '', '', [['type' => 's', 'value' => $id_pengajuan]]);

  // Data yang akan diupdate di tabel
  $data = [
    'tanggal_pengajuan' => $tanggal_pengajuan,
    'waktu_mulai' => $waktu_mulai,
    'waktu_selesai' => $waktu_selesai,
    'keterangan' => $keterangan,
  ];

  // Kondisi untuk menentukan pengajuan lembur mana yang akan diupdate
  $conditions = "id_pengajuan = '$id_pengajuan'";
  // Panggil fungsi updateData untuk mengupdate data di tabel pengajuan lembur
  $result = updateData($table_name, $data, $conditions);

  // Periksa apakah data berhasil diupdate
  if ($result > 0) {
      $_SESSION['success_message'] = "Pengajuan lembur berhasil diupdate!";

      // Ambil data setelah diubah
      $newData = selectData('pengajuan_lembur', 'id_pengajuan = ?', '', '', [['type' => 's', 'value' => $id_kontak]]);

      // Data sebelum dan sesudah perubahan untuk log
      $before = $oldData[0]; // Ambil baris pertama dari hasil query
      $after = $newData[0]; // Ambil baris pertama dari hasil query

      // Keterangan perubahan
      $changeDescription = "Perubahan data pengajuan lembur: | ";

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
        'aktivitas' => 'Ubah Data pengajuan lembur',
        'tabel' => 'pengajuan_lembur',
        'keterangan' => $changeDescription,
      ];

      insertData('log_aktivitas', $logData);
  } else {
      $_SESSION['error_message'] = "Terjadi kesalahan saat mengupdate pengajuan lembur.";
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