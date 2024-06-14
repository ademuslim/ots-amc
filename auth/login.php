<?php
require_once '../includes/function.php';

// Periksa apakah pengguna sudah login
if (isset($_SESSION['peran_pengguna'])) {
    // Jika sudah login, arahkan pengguna sesuai peran
    redirectUser($_SESSION['peran_pengguna']);
} elseif (isset($_COOKIE['ingat_user_id'])) {
    // Jika tidak ada sesi, tapi ada cookie "ingat akun", coba lakukan otentikasi berdasarkan cookie
    $ingat_user_id = $_COOKIE['ingat_user_id'];
    
    // Lakukan otentikasi berdasarkan cookie
    if (authenticateByUserId($ingat_user_id)) {
        $peran_pengguna = getUserRoleById($ingat_user_id); // Dapatkan peran pengguna berdasarkan ID pengguna
        $_SESSION['peran_pengguna'] = $peran_pengguna;
        redirectUser($peran_pengguna);
    } else {
        // Jika otentikasi gagal, arahkan ke halaman login
        header("Location: " . base_url('auth/login.php'));
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Invoice Management System</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <script src="<?= base_url('assets/js/jquery.js'); ?>"></script>
</head>

<body class="bg-light">
  <div class="container min-vh-100 d-flex flex-column align-items-center justify-content-center  position-relative">
    <h1 class="fs-2 fw-bold text-center mb-5">SISTEM LEMBUR</h1>
    <div class="card border border-light shadow p-4 w-50 custom-card" style="min-width:350px;">
      <form method="post" action="process.php">
        <p>Silahkan masuk</p>

        <div class="form-floating mb-3">
          <input type="username" class="form-control" id="username" name="username" placeholder="Username">
          <label for="username" style="color: black;">Username</label>
        </div>

        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          <label for="email" style="color: black;">Password</label>
        </div>

        <?php 
        // Cek apakah ada pesan kesalahan yang disimpan dalam session
        if (isset($_SESSION['login_error'])) {
        ?>
        <!-- Jika ada, tampilkan pesan kesalahan dalam elemen alert -->
        <div class="alert alert-danger alert-lg d-flex align-items-center" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" class="bi bi-exclamation-triangle-fill me-3"
            viewBox="0 0 16 16" role="img" aria-label="Warning:" style="fill:currentColor;">
            <path
              d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
          </svg>
          <?= $_SESSION['login_error']; ?>
        </div>

        <?php
          // Setelah menampilkan pesan, hapus pesan dari session agar tidak ditampilkan lagi setelah reload
          unset($_SESSION['login_error']);
        }
        ?>

        <div class="form-check text-start my-3">
          <input class="form-check-input" type="checkbox" value="remember-me" id="remember_me" name="remember_me">
          <label class="form-check-label" for="remember_me">
            Ingat saya
          </label>
        </div>
        <div class="d-flex flex-row justify-content-end align-items-center">
          <!-- <p class="my-auto">Belum punya akun? <a href="register.php" class="text-dark">Daftar</a>.</p> -->
          <button class="btn btn-primary ms-3" type="submit" name="login_submit">LOG IN</button>
        </div>
      </form>
    </div>

    <p class="fs-6 position-absolute bottom-0 end-0 mt-5 mb-3 text-body-secondary">&copy; 2024 Sistem Lembur | Irvanda
      Nur Arifin
    </p>
  </div>

  <script src="<?= base_url('assets/js/popper.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
  <script>
  // Memberikan fokus otomatis pada input email saat halaman dimuat
  window.onload = function() {
    document.getElementById("username").focus();
  };
  </script>
</body>

</html>