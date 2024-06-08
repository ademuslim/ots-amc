<?php
require '../../../includes/function.php';
require '../../../includes/vendor/autoload.php';

// Ambil id_pengguna dari sesi atau cookie untuk pencatatan log aktivitas
$id_pengguna = $_SESSION['id_pengguna'] ?? $_COOKIE['ingat_user_id'] ?? '';

$table_name = 'jabatan';

if (isset($_POST['add'])) {
    $nama_jabatan = strtolower($_POST['nama_jabatan']);
    $harga_lembur = $_POST['harga_lembur'];
    
    // Generate UUID untuk kolom id_pengirim
    $id_jabatan = Ramsey\Uuid\Uuid::uuid4()->toString();

    // Data yang akan dimasukkan ke dalam tabel produk
    $data = [
        'id_jabatan' => $id_jabatan,
        'nama_jabatan' => $nama_jabatan,
        'harga_lembur' => $harga_lembur
    ];

  // Panggil fungsi insertData untuk menambahkan data ke dalam tabel jabatan
  $result = insertData($table_name, $data);

  // Periksa apakah data berhasil ditambahkan
  if ($result > 0) {
      $_SESSION['success_message'] = "jabatan berhasil ditambahkan!";

      // Pencatatan log aktivitas
      $id_log = Ramsey\Uuid\Uuid::uuid4()->toString();
      $aktivitas = 'Berhasil tambah jabatan';
      $tabel = 'jabatan';
      $keterangan = 'Pengguna dengan ID ' . $id_pengguna . ' berhasil tambah jabatan dengan ID ' . $id_jabatan;
      $log_data = [
          'id_log' => $id_log,
          'id_pengguna' => $id_pengguna,
          'aktivitas' => $aktivitas,
          'tabel' => $tabel,
          'keterangan' => $keterangan
      ];
      insertData('log_aktivitas', $log_data);
  } else {
      $_SESSION['error_message'] = "Terjadi kesalahan saat menambahkan jabatan.";

      // Pencatatan log aktivitas
      $id_log = Ramsey\Uuid\Uuid::uuid4()->toString();
      $aktivitas = 'Gagal tambah jabatan';
      $tabel = 'jabatan';
      $keterangan = 'Pengguna dengan ID ' . $id_pengguna . ' gagal tambah jabatan ' . $kategori;
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
  $id_jabatan = $_POST['id_jabatan'];
  $nama_jabatan = strtolower($_POST['nama_jabatan']);
  $harga_lembur = $_POST['harga_lembur'];

  // Ambil data lama sebelum diubah
  $oldData = selectData('jabatan', 'id_jabatan = ?', '', '', [['type' => 's', 'value' => $id_jabatan]]);

  // Data yang akan diupdate di tabel
  $data = [
    'nama_jabatan' => $nama_jabatan,
    'harga_lembur' => $harga_lembur
  ];

  // Kondisi untuk menentukan jabatan mana yang akan diupdate
  $conditions = "id_jabatan = '$id_jabatan'";
  // Panggil fungsi updateData untuk mengupdate data di tabel jabatan
  $result = updateData($table_name, $data, $conditions);

  // Periksa apakah data berhasil diupdate
  if ($result > 0) {
      $_SESSION['success_message'] = "jabatan berhasil diupdate!";

      // Ambil data setelah diubah
      $newData = selectData('jabatan', 'id_jabatan = ?', '', '', [['type' => 's', 'value' => $id_jabatan]]);

      // Data sebelum dan sesudah perubahan untuk log
      $before = $oldData[0]; // Ambil baris pertama dari hasil query
      $after = $newData[0]; // Ambil baris pertama dari hasil query

      // Keterangan perubahan
      $changeDescription = "Perubahan data jabatan: | ";

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
        'aktivitas' => 'Ubah Data jabatan',
        'tabel' => 'jabatan',
        'keterangan' => $changeDescription,
      ];

      insertData('log_aktivitas', $logData);
  } else {
      $_SESSION['error_message'] = "Terjadi kesalahan saat mengupdate jabatan.";
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