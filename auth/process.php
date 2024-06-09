<?php
require_once '../includes/function.php';
require '../includes/vendor/autoload.php';

// Jika pengguna sudah login, arahkan ke halaman utama
if (isset($_SESSION['peran_pengguna'])) {
    redirectUser($_SESSION['peran_pengguna']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Cek apakah tombol login atau registrasi yang ditekan
    // Tentukan waktu kedaluwarsa cookie (dalam detik)
    $expiry_time = 86400; // Satu hari (24 jam * 60 menit * 60 detik)
    if (isset($_POST['login_submit'])) {
        // Tangani form login jika dikirimkan
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Lakukan autentikasi pengguna
        $user = authenticateUser($email, $password);

        if ($user) {
            // Simpan informasi pengguna ke sesi
            $_SESSION['id_pengguna'] = $id_pengguna = $user['id_pengguna'];
            $_SESSION['peran_pengguna'] = $user['tipe_pengguna'];
            $_SESSION['nama_pengguna'] = $user['nama_pengguna'];

            // Pencatatan log aktivitas
            $id_log = Ramsey\Uuid\Uuid::uuid4()->toString();
            $aktivitas = 'Login berhasil';
            $tabel = 'pengguna';
            $keterangan = 'Pengguna dengan email ' . $email . ' berhasil login.';
            $log_data = [
                'id_log' => $id_log,
                'id_pengguna' => $id_pengguna,
                'aktivitas' => $aktivitas,
                'tabel' => $tabel,
                'keterangan' => $keterangan
            ];
            insertData('log_aktivitas', $log_data);

            // Set pesan login berhasil
            $_SESSION['success_message'] = "Login berhasil! Selamat datang, " . ucwords($user['nama_pengguna']) . ".";
    
            // Jika dicentang, set cookie "ingat akun" dengan ID pengguna
            if (isset($_POST['remember_me'])) {
                // Atur cookie dengan ID pengguna dan waktu kedaluwarsa yang ditentukan
                $user_id = $user['id_pengguna'];
                setcookie("ingat_user_id", $user_id, time() + $expiry_time, "/"); // Cookie berlaku selama waktu yang ditentukan
                setcookie("nama_pengguna", $user['nama_pengguna'], time() + $expiry_time, "/"); // Cookie berlaku selama waktu yang ditentukan
            } else {
                // Jika checkbox "ingat saya" tidak dicentang, hapus cookie "ingat akun" jika ada
                if (isset($_COOKIE['ingat_user_id'])) {
                    setcookie("ingat_user_id", "", time() - 3600, "/"); // Hapus cookie "ingat akun"
                }
            }
    
            // Redirect ke halaman utama setelah berhasil login
            header("Location: " . base_url('index.php'));
            exit();
        } else {
            // Jika autentikasi gagal, tampilkan pesan kesalahan dan simpan ke dalam session
            $_SESSION['login_error'] = "Email dan password salah. Silakan coba lagi.";

            // Pencatatan log aktivitas
            $id_log = Ramsey\Uuid\Uuid::uuid4()->toString();
            $aktivitas = 'Login gagal';
            $tabel = 'pengguna';
            $keterangan = 'Gagal login dengan email ' . $email . '. Email atau password salah.';
            $log_data = [
                'id_log' => $id_log,
                'aktivitas' => $aktivitas,
                'tabel' => $tabel,
                'keterangan' => $keterangan
            ];
            insertData('log_aktivitas', $log_data);

            header("Location: " . base_url('auth/login.php'));
            exit();
        }
    }
} else {
    // Jika bukan metode POST, arahkan ke halaman login
    header("Location: " . base_url('auth/login.php'));
    exit();
}