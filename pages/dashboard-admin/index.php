<?php
$page_title = "Dashboard";
require_once '../../includes/header.php';

// Ambil semua data lembur dari semua karyawan dengan status disetujui
$status1 = 'pending';
$karyawanLemburDataPending = getAllLemburData($status1);

// Proses data lembur ke dalam array tanggal
$lemburDatesPending = [];
foreach ($karyawanLemburDataPending as $lembur) {
    $lemburDatesPending[$lembur['tanggal_pengajuan']] = true;
}

// Ambil semua data lembur dari semua karyawan dengan status disetujui
$status2 = 'disetujui';
$karyawanLemburDataDiSetujui = getAllLemburData($status2);

// Proses data lembur ke dalam array tanggal
$lemburDatesDiSetujui = [];
foreach ($karyawanLemburDataDiSetujui as $lembur) {
    $lemburDatesDiSetujui[$lembur['tanggal_pengajuan']] = true;
}

// Ambil semua data lembur dari semua karyawan dengan status ditolak
$status3 = 'ditolak';
$karyawanLemburDataDiTolak = getAllLemburData($status3);

// Proses data lembur ke dalam array tanggal
$lemburDatesDiTolak = [];
foreach ($karyawanLemburDataDiTolak as $lembur) {
    $lemburDatesDiTolak[$lembur['tanggal_pengajuan']] = true;
}

// Daftar bulan dalam bahasa Indonesia
$bulanIndonesia = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
];

// Mendapatkan bulan dan tahun yang dipilih (jika ada), atau gunakan nilai default bulan saat ini
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Mendefinisikan array untuk menampung tanggal dalam bulan yang dipilih
$dates = [];
$start = new DateTime("first day of $selectedYear-$selectedMonth");
$end = new DateTime("last day of $selectedYear-$selectedMonth");

while ($start <= $end) {
    $dates[] = $start->format('Y-m-d');
    $start->modify('+1 day');
}

$currentDate = date('Y-m-d');
$currentMonthYear = formatTanggalIndonesia($currentDate);
?>

<div class="row mb-4">
  <!-- Greeting -->
  <div class="col">
    <div class="card custom-card d-flex flex-column h-100">
      <div class="card-body">
        <h5 class="card-title">Selamat Datang, <?= ucwords($karyawan_log['nama_karyawan']); ?></h5>
        <h6 class="card-subtitle mb-2">Sistem Lembur, Home Care Unit</h6>
        <h6 class="card-subtitle">Lippo Cikarang</h6>
      </div>
    </div>
  </div>
</div>

<!-- Filter -->
<div class="row mb-4">
  <div class="col">
    <div class="card d-flex flex-column h-100">
      <div class="card-body">
        <form action="" method="GET">
          <div class="row align-items-center">
            <div class="col-auto">
              <label for="month">Bulan</label>
            </div>

            <div class="col-auto">
              <select name="month" id="month" class="form-control">
                <?php foreach ($bulanIndonesia as $key => $bulan): ?>
                <option value="<?= $key ?>" <?= $key == $selectedMonth ? 'selected' : '' ?>>
                  <?= $bulan ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-auto">
              <label for="month">Tahun</label>
            </div>

            <div class="col-auto">
              <input type="number" name="year" id="year" class="form-control" value="<?= $selectedYear ?>">
            </div>
            <div class="col-auto">
              <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            <div class="col-auto">
              <button type="button" class="btn btn-primary btn-sm">
                <a href="<?= base_url('pages/dashboard'); ?>"
                  class="nav-link text-dark bg-transparent <?= setActivePage('pages/dashboard'); ?>">
                  <span class="text-link">
                    Refresh
                  </span>
                </a>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row mb-4">
  <!-- Data Lembur Pending -->
  <div class="col">
    <div class="card d-flex flex-column h-100">
      <div class="card-header">
        Data Lembur Semua Karyawan Pending
      </div>
      <div class="card-body">
        <div class="calendar">
          <?php foreach ($dates as $date): ?>
          <div class="day <?= isset($lemburDatesPending[$date]) ? 'pending-lembur' : '' ?>">
            <?= (new DateTime($date))->format('j') ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /////////////////////// -->
<div class="row mb-4">
  <!-- Data Lembur Disetujui -->
  <div class="col">
    <div class="card d-flex flex-column h-100">
      <div class="card-header">
        Data Lembur Semua Karyawan
      </div>
      <div class="card-body">
        <div class="calendar">
          <?php foreach ($dates as $date): ?>
          <div class="day <?= isset($lemburDatesDiSetujui[$date]) ? 'lembur' : '' ?>">
            <?= (new DateTime($date))->format('j') ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /////////////////////// -->
<div class="row mb-4">
  <!-- Data Lembur Ditolak -->
  <div class="col">
    <div class="card d-flex flex-column h-100">
      <div class="card-header">
        Data Lembur Semua Karyawan
      </div>
      <div class="card-body">
        <div class="calendar">
          <?php foreach ($dates as $date): ?>
          <div class="day <?= isset($lemburDatesDiTolak[$date]) ? 'batal-lembur' : '' ?>">
            <?= (new DateTime($date))->format('j') ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /////////////////////// -->
<?php
require_once '../../includes/footer.php';
?>