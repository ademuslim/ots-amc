<?php // master-data/product/del
require '../../includes/function.php';
require '../../includes/vendor/autoload.php';

// Ambil id_pengguna dari sesi atau cookie untuk pencatatan log aktivitas
$id_pengguna = $_SESSION['id_pengguna'] ?? $_COOKIE['ingat_user_id'] ?? '';

if (isset($_GET['id'])) {
    // Ambil ID produk yang akan dihapus
    $id = $_GET['id'];

    // Cek tanggal pengajuan dari tabel pengajuan_lembur
    $queryPengajuan = "SELECT tanggal_pengajuan FROM pengajuan_lembur WHERE id_pengajuan = ?";
    $stmtPengajuan = $conn->prepare($queryPengajuan);
    $stmtPengajuan->bind_param('s', $id);
    $stmtPengajuan->execute();
    $resultPengajuan = $stmtPengajuan->get_result()->fetch_assoc();

    if ($resultPengajuan) {
        $tanggal_pengajuan = new DateTime($resultPengajuan['tanggal_pengajuan']);
        $sekarang = new DateTime();
        $interval = $sekarang->diff($tanggal_pengajuan);

        // Ambil status terbaru dari tabel persetujuan_lembur
        $status = getStatusPengajuan($id);

        // Cek apakah status pending atau sudah lebih dari satu bulan
        if ($status == 'pending' || $interval->m >= 1 || $interval->y > 0) {
            deleteData('persetujuan_lembur', "id_pengajuan = '$id'");
            $deleteResult = deleteData('pengajuan_lembur', "id_pengajuan = '$id'");

            if ($deleteResult > 0) {
                // Jika berhasil menghapus, tampilkan pesan sukses
                $_SESSION['success_message'] = "Data pengajuan lembur berhasil dihapus!";

                // Pencatatan log aktivitas
                $id_log = Ramsey\Uuid\Uuid::uuid4()->toString();
                $aktivitas = 'Berhasil hapus pengajuan lembur';
                $tabel = 'pengajuan lembur';
                $keterangan = 'Pengguna dengan ID ' . $id_pengguna . ' berhasil hapus pengajuan lembur dengan ID ' . $id;
                $log_data = [
                    'id_log' => $id_log,
                    'id_pengguna' => $id_pengguna,
                    'aktivitas' => $aktivitas,
                    'tabel' => $tabel,
                    'keterangan' => $keterangan
                ];
                insertData('log_aktivitas', $log_data);
            } else {
                // Jika gagal menghapus, tampilkan pesan error
                $_SESSION['error_message'] = "Terjadi kesalahan saat menghapus data pengajuan lembur.";

                // Pencatatan log aktivitas
                $id_log = Ramsey\Uuid\Uuid::uuid4()->toString();
                $aktivitas = 'Gagal hapus pengajuan lembur';
                $tabel = 'pengajuan lembur';
                $keterangan = 'Pengguna dengan ID ' . $id_pengguna . ' gagal hapus pengajuan lembur dengan ID ' . $id;
                $log_data = [
                    'id_log' => $id_log,
                    'id_pengguna' => $id_pengguna,
                    'aktivitas' => $aktivitas,
                    'tabel' => $tabel,
                    'keterangan' => $keterangan
                ];
                insertData('log_aktivitas', $log_data);
            }
        } else {
            // Jika belum satu bulan dan status tidak pending, tampilkan pesan error
            $_SESSION['error_message'] = "Data pengajuan lembur tidak boleh dihapus karena belum satu bulan sejak tanggal pengajuan dan status tidak pending.";

            // Pencatatan log aktivitas
            $id_log = Ramsey\Uuid\Uuid::uuid4()->toString();
            $aktivitas = 'Gagal hapus pengajuan lembur';
            $tabel = 'pengajuan lembur';
            $keterangan = 'Pengguna dengan ID ' . $id_pengguna . ' mencoba hapus pengajuan lembur dengan ID ' . $id . ' yang belum satu bulan sejak tanggal pengajuan dan status tidak pending';
            $log_data = [
                'id_log' => $id_log,
                'id_pengguna' => $id_pengguna,
                'aktivitas' => $aktivitas,
                'tabel' => $tabel,
                'keterangan' => $keterangan
            ];
            insertData('log_aktivitas', $log_data);
        }
    } else {
        // Jika tidak ditemukan data dengan ID tersebut, tampilkan pesan error
        $_SESSION['error_message'] = "ID pengajuan lembur tidak valid.";
    }
} else {
    // Jika tidak ada ID yang diberikan, tampilkan pesan error
    $_SESSION['error_message'] = "ID pengajuan lembur tidak valid.";
}

// Redirect kembali ke index.php setelah proses selesai
header("Location: index.php");
exit();
?>