<?php
require '../../includes/function.php';
require '../../includes/vendor/autoload.php';

// Ambil id_pengguna dari sesi atau cookie untuk pencatatan log aktivitas
$id_pengguna = $_SESSION['id_pengguna'] ?? $_COOKIE['ingat_user_id'] ?? '';

$table_name = 'pengajuan_lembur';
if (isset($_POST['approve'])) {
  // Ambil data dari form
  $id_pengajuan = $_POST['id_pengajuan'];
  $status = $_POST['status'];
  $disetujui_oleh = $_POST['disetujui_oleh']; // ID karyawan yang menyetujui (diambil dari session)
  $tanggal_persetujuan = date('Y-m-d H:i:s'); // Menggunakan format datetime

  // Generate UUID untuk kolom id_persetujuan
  $id_persetujuan = Ramsey\Uuid\Uuid::uuid4()->toString();

  // Validasi data
  if (empty($status)) {
      $_SESSION['error_message'] = "Mohon pilih status!";
      header('Location: index.php');
      exit();
  } else {
      // Data untuk dimasukkan ke tabel persetujuan_lembur
      $data = [
          'id_persetujuan' => $id_persetujuan,
          'id_pengajuan' => $id_pengajuan,
          'disetujui_oleh' => $disetujui_oleh,
          'tanggal_persetujuan' => $tanggal_persetujuan,
          'status' => $status
      ];

      // Insert data persetujuan lembur menggunakan fungsi insertData
      $result = insertData('persetujuan_lembur', $data);

      if ($result) {
          $_SESSION['success_message'] = "Pengajuan lembur berhasil diperbarui!";
      } else {
          $_SESSION['error_message'] = "Gagal memperbarui pengajuan lembur!";
      }
      header('Location: index.php');
      exit();
  }
}