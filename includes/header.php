<?php
require_once 'function.php';

if (!checkLoginStatus()) {
    header("Location: " . base_url('auth/login.php'));
    exit();
}

// Ambil id_pengguna dari sesi atau cookie
$id_pengguna = $_SESSION['id_pengguna'] ?? $_COOKIE['ingat_user_id'] ?? '';

// Variabel untuk menyimpan data karyawan yang login
$karyawan_log = [];

if ($id_pengguna) {
    // Definisikan parameter untuk fungsi selectDataJoin
    $mainTable = "pengguna";
    $joinTables = [
      ["karyawan", "pengguna.id_karyawan = karyawan.id_karyawan"],
      ["jabatan", "karyawan.id_jabatan = jabatan.id_jabatan"]
    ];
    $columns = "pengguna.*, karyawan.*, jabatan.*";
    $conditions = "pengguna.id_pengguna = '$id_pengguna'";

    // Ambil data karyawan
    $karyawanData = selectDataJoin($mainTable, $joinTables, $columns, $conditions);

    // Periksa apakah data karyawan ditemukan
    if (!empty($karyawanData)) {
        $karyawan_log = $karyawanData[0]; // Ambil data karyawan pertama (seharusnya hanya satu)
    } else {
        // Jika data karyawan tidak ditemukan, kosongkan variabel $karyawan
        $karyawan_log = [];
    }
} else {
    echo "Pengguna tidak terautentikasi.";
}

// Ambil nama_pengguna dari sesi atau cookie
$nama_pengguna = $_SESSION['nama_pengguna'] ?? $_COOKIE['nama_pengguna'] ?? '';
$peran_pengguna = $_SESSION['peran_pengguna'] ?? $_COOKIE['peran_pengguna'] ?? '';

// Tampilkan pesan sukses jika ada
if (isset($_SESSION['success_message'])) {
  $success_message = $_SESSION['success_message'];
  unset($_SESSION['success_message']);
} else {
  $success_message = '';
}

// Tampilkan pesan error jika ada
if (isset($_SESSION['error_message'])) {
  $error_message = $_SESSION['error_message'];
  unset($_SESSION['error_message']);
} else {
  $error_message = '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($page_title) ? "$page_title | Sistem Lembur" : 'Sistem Lembur' ?></title>
  <script src="<?= base_url('assets/js/jquery.js'); ?>"></script>
  <!-- DataTables Responsive Bootstrap5 CSS-->
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/dataTables.bootstrap5.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/responsive.bootstrap5.css'); ?>">
  <!-- DataTables Button CSS-->
  <link rel="stylesheet" href="<?= base_url('assets/css/buttons.dataTables.css'); ?>">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/sweetalert2.min.css'); ?>">
  <!-- SweetAlert2 JS -->
  <script src="<?= base_url('assets/js/sweetalert2.all.min.js'); ?>"></script>
  <!-- ChartJS -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

  <style>
  .show-immediate {
    display: block !important;
    height: auto !important;
    transition: none !important;
  }

  .no-transition .accordion-button:not(.collapsed)::after {
    transition: none !important;
  }

  .loader-container {
    display: none;
    /* Awalnya sembunyikan loader */
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    min-height: 100%;
    background-color: #f2fafd;
    /* Transparan */
    z-index: 9999;
    /* Pastikan loader di atas konten lain */
  }

  .loader {
    border: 8px solid #f3f3f3;
    /* Warna loader */
    border-radius: 50%;
    border-top: 8px solid #3498db;
    /* Warna loader */
    width: 60px;
    height: 60px;
    animation: spin 2s linear infinite;
    /* Animasi putaran */
    position: absolute;
    left: 50%;
    top: 100px;
    transform: translateX(-50%);
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  /* Custom sweetalert */
  .swal2-popup {
    font-size: 0.8rem;
    /* Ubah ukuran font */
    width: 300px;
    /* Ubah lebar */
    background: #3e3b92 !important;
    /* Ubah warna background */
    color: white;
  }

  .swal2-content {
    color: white !important;
    /* Ubah warna teks isi pesan menjadi putih */
  }

  .swal2-close {
    font-size: 1rem;
    /* Ubah ukuran tombol close */
  }

  /* Dashboard */
  .calendar {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    /* Rata kiri */
    align-content: flex-start;
    gap: 4px;
    /* Tambahkan gap antara kotak kalender */
  }

  .day {
    width: calc(100% / 7 - 8px);
    /* 7 hari dalam seminggu dan sedikit margin */
    height: 40px;
    /* Atur tinggi kotak */
    background-color: #ccc;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 12px;
    color: #000;
  }

  .day.pending-lembur {
    background-color: orange;
    color: white;
  }

  .day.lembur {
    background-color: green;
    color: white;
  }

  .day.batal-lembur {
    background-color: red;
    color: white;
  }

  @media (max-width: 768px) {
    .day {
      width: calc(100% / 7 - 8px);
      /* Sesuaikan lebar untuk layar kecil */
    }
  }
  </style>
</head>

<body>
  <div class="sb-cover">
    <div class="sidebar">
      <div class="resizer"></div>
      <div class="sidebar-top">
        <div class="header">
          <a href="/" class="nav-link">
            <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px">
              <path
                d="m787-145 28-28-75-75v-112h-40v128l87 87Zm-587 25q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v268q-19-9-39-15.5t-41-9.5v-243H200v560h242q3 22 9.5 42t15.5 38H200Zm0-120v40-560 243-3 280Zm80-40h163q3-21 9.5-41t14.5-39H280v80Zm0-160h244q32-30 71.5-50t84.5-27v-3H280v80Zm0-160h400v-80H280v80ZM720-40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Z" />
            </svg>
            <span class="text-link">
              Sistem Lembur
            </span>
          </a>
        </div>
        <hr>
        <ul>
          <!-- Dashboard Staff Admin dan Superadmin -->
          <?php if ($_SESSION['peran_pengguna'] === 'superadmin' || $_SESSION['peran_pengguna'] === 'staff'): ?>
          <li>
            <a href="<?= base_url('pages/dashboard-admin'); ?>"
              class="nav-link text-dark <?= setActivePage('pages/dashboard-admin'); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 -960 960 960" width="18">
                <path
                  d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z" />
              </svg>
              <span class="text-link">
                Dashboard
              </span>
            </a>
          </li>
          <?php endif; ?>

          <!-- Dashboard PIC -->
          <?php if ($_SESSION['peran_pengguna'] === 'pic'): ?>
          <li>
            <a href="<?= base_url('pages/dashboard'); ?>"
              class="nav-link text-dark <?= setActivePage('pages/dashboard'); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 -960 960 960" width="18">
                <path
                  d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z" />
              </svg>
              <span class="text-link">
                Dashboard
              </span>
            </a>
          </li>
          <?php endif; ?>

          <?php if ($_SESSION['peran_pengguna'] === 'superadmin' || $_SESSION['peran_pengguna'] === 'staff'): ?>
          <li>
            <div class="accordion accordion-flush" style="background-color: transparent;" id="accordionFlushMasterData">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed nav-link" type="button" data-bs-toggle="collapse"
                    data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">

                    <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px">
                      <path
                        d="M168-216v-432 432-9 9Zm0 72q-29.7 0-50.85-21.15Q96-186.3 96-216v-432q0-29.7 21.15-50.85Q138.3-720 168-720h168v-72.21Q336-822 357.18-843q21.17-21 50.91-21h144.17Q582-864 603-842.85q21 21.15 21 50.85v72h168q29.7 0 50.85 21.15Q864-677.7 864-648v227q-16-16-34-29.5T792-475v-173H168v432h241q3 18 6 36.5t11 35.5H168Zm240-576h144v-72H408v72ZM671.77-48Q592-48 536-104.23q-56-56.22-56-136Q480-320 536.23-376q56.22-56 136-56Q752-432 808-375.77q56 56.22 56 136Q864-160 807.77-104q-56.22 56-136 56ZM696-250v-86h-48v106l79 79 34-34-65-65Z" />
                    </svg>
                    <span class="text-link">
                      Master Data
                    </span>
                  </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse"
                  data-bs-parent="#accordionFlushMasterData">
                  <div class="accordion-body">
                    <ul>
                      <li>
                        <a href="<?= base_url('pages/master-data/jabatan'); ?>"
                          class="nav-link <?= setActivePage('pages/master-data/jabatan'); ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px">
                            <path
                              d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17-62.5t47-43.5q60-30 124.5-46T480-440q67 0 131.5 16T736-378q30 15 47 43.5t17 62.5v112H160Zm320-400q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm160 228v92h80v-32q0-11-5-20t-15-14q-14-8-29.5-14.5T640-332Zm-240-21v53h160v-53q-20-4-40-5.5t-40-1.5q-20 0-40 1.5t-40 5.5ZM240-240h80v-92q-15 5-30.5 11.5T260-306q-10 5-15 14t-5 20v32Zm400 0H320h320ZM480-640Z" />
                          </svg>
                          <span class="text-link">
                            Jabatan
                          </span>
                        </a>
                      </li>

                      <li>
                        <a href="<?= base_url('pages/master-data/karyawan'); ?>"
                          class="nav-link <?= setActivePage('pages/master-data/karyawan'); ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px">
                            <path
                              d="M160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm80-80h240v-18q0-17-9.5-31.5T444-312q-20-9-40.5-13.5T360-330q-23 0-43.5 4.5T276-312q-17 8-26.5 22.5T240-258v18Zm320-60h160v-60H560v60Zm-200-60q25 0 42.5-17.5T420-420q0-25-17.5-42.5T360-480q-25 0-42.5 17.5T300-420q0 25 17.5 42.5T360-360Zm200-60h160v-60H560v60ZM440-600h80v-200h-80v200Zm40 220Z" />
                          </svg>
                          <span class="text-link">
                            Data Karyawan
                          </span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <?php endif; ?>

          <?php if ($_SESSION['peran_pengguna'] === 'pic'): ?>
          <li>
            <a href="<?= base_url('pages/pengajuan-lembur'); ?>"
              class="nav-link text-dark <?= setActivePage('pages/pengajuan-lembur'); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px">
                <path
                  d="M160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm80-80h240v-18q0-17-9.5-31.5T444-312q-20-9-40.5-13.5T360-330q-23 0-43.5 4.5T276-312q-17 8-26.5 22.5T240-258v18Zm320-60h160v-60H560v60Zm-200-60q25 0 42.5-17.5T420-420q0-25-17.5-42.5T360-480q-25 0-42.5 17.5T300-420q0 25 17.5 42.5T360-360Zm200-60h160v-60H560v60ZM440-600h80v-200h-80v200Zm40 220Z" />
              </svg>
              <span class="text-link">
                Data Lembur
              </span>
            </a>
          </li>
          <?php endif; ?>

          <?php if ($_SESSION['peran_pengguna'] === 'superadmin' || $_SESSION['peran_pengguna'] === 'staff'): ?>
          <li>
            <a href="<?= base_url('pages/data-lembur'); ?>"
              class="nav-link text-dark <?= setActivePage('pages/data-lembur'); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px">
                <path
                  d="M160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm80-80h240v-18q0-17-9.5-31.5T444-312q-20-9-40.5-13.5T360-330q-23 0-43.5 4.5T276-312q-17 8-26.5 22.5T240-258v18Zm320-60h160v-60H560v60Zm-200-60q25 0 42.5-17.5T420-420q0-25-17.5-42.5T360-480q-25 0-42.5 17.5T300-420q0 25 17.5 42.5T360-360Zm200-60h160v-60H560v60ZM440-600h80v-200h-80v200Zm40 220Z" />
              </svg>
              <span class="text-link">
                Data Lembur
              </span>
            </a>
          </li>
          <?php endif; ?>

          <?php if ($_SESSION['peran_pengguna'] === 'superadmin'): ?>
          <li>
            <a href="<?= base_url('pages/activity-log'); ?>"
              class="nav-link text-dark <?= setActivePage('pages/activity-log'); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 -960 960 960" width="18">
                <path
                  d="M80-680v-120q0-33 23.5-56.5T160-880h120v80H160v120H80ZM280-80H160q-33 0-56.5-23.5T80-160v-120h80v120h120v80Zm400 0v-80h120v-120h80v120q0 33-23.5 56.5T800-80H680Zm120-600v-120H680v-80h120q33 0 56.5 23.5T880-800v120h-80ZM540-580q-33 0-56.5-23.5T460-660q0-33 23.5-56.5T540-740q33 0 56.5 23.5T620-660q0 33-23.5 56.5T540-580Zm-28 340H352l40-204-72 28v136h-80v-188l158-68q35-15 51.5-19.5T480-560q21 0 39 11t29 29l40 64q26 42 70.5 69T760-360v80q-66 0-123.5-27.5T540-380l-28 140Z" />
              </svg>
              <span class="text-link">
                Log Aktivitas
              </span>
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </div>

      <div class="sidebar-bottom">
        <hr>
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center text-dark text-decoration-none nav-link"
            data-bs-toggle="dropdown" aria-expanded="false">
            <span class="rounded-circle bg-secondary text-white"
              style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
              <?php
                // Ubah nama pengguna menjadi huruf besar untuk memastikan konsistensi
                // Cetak nama karyawan jika data karyawan ditemukan
                if (!empty($karyawan_log)) {
                  $nama_karyawan = $karyawan_log['nama_karyawan'];
                  $jabatan_karyawan = $karyawan_log['nama_jabatan'];
                  $nama_pengguna = $karyawan_log['nama_pengguna'];
                  // Memisahkan nama pengguna menjadi kata-kata terpisah
                  $kata = explode(" ", $nama_karyawan);

                  // Inisialisasi variabel untuk menyimpan inisial
                  $inisial = '';

                  // Iterasi melalui setiap kata dalam nama pengguna
                  foreach ($kata as $kata_satu) {
                      // Ambil huruf pertama dari setiap kata dan tambahkan ke inisial
                      $inisial .= substr($kata_satu, 0, 1);
                  }

                  // Tampilkan inisial
                  echo strtoupper($inisial);
                  
                } else {
                  echo "Data karyawan tidak ditemukan.";
                }
                ?>
            </span>
            <span class="text-link"><?= ucwords($nama_karyawan); ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <?php if ($_SESSION['peran_pengguna'] === 'superadmin' || $_SESSION['peran_pengguna'] === 'staff'): ?>
            <li><a class="dropdown-item" href="<?= base_url('pages/users'); ?>">Data Pengguna</a>
            </li>
            <?php endif; ?>

            <li>
              <hr class="dropdown-divider">
            </li>

            <span class="ps-3">
              <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="18px" fill="#fff">
                <path
                  d="M237-285q54-38 115.5-56.5T480-360q66 0 127.5 18.5T723-285q35-41 52-91t17-104q0-129.67-91.23-220.84-91.23-91.16-221-91.16Q350-792 259-700.84 168-609.67 168-480q0 54 17 104t52 91Zm243-123q-60 0-102-42t-42-102q0-60 42-102t102-42q60 0 102 42t42 102q0 60-42 102t-102 42Zm.28 312Q401-96 331-126t-122.5-82.5Q156-261 126-330.96t-30-149.5Q96-560 126-629.5q30-69.5 82.5-122T330.96-834q69.96-30 149.5-30t149.04 30q69.5 30 122 82.5T834-629.28q30 69.73 30 149Q864-401 834-331t-82.5 122.5Q699-156 629.28-126q-69.73 30-149 30Zm-.28-72q52 0 100-16.5t90-48.5q-43-27-91-41t-99-14q-51 0-99.5 13.5T290-233q42 32 90 48.5T480-168Zm0-312q30 0 51-21t21-51q0-30-21-51t-51-21q-30 0-51 21t-21 51q0 30 21 51t51 21Zm0-72Zm0 319Z" />
              </svg>
            </span>
            <span><?= ucwords($peran_pengguna) ?></span>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li><a class="dropdown-item" href="<?= base_url('auth/logout.php'); ?>">Sign out</a></li>
          </ul>
        </div>

      </div>
    </div>
  </div>

  <div class="rs-content" style="position: relative;">
    <div id="loader" class="loader-container">
      <div class="loader"></div>
    </div>