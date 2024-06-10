<?php
$page_title = "Dashboard";
require_once '../../includes/header.php';

// Ambil semua data lembur dari semua karyawan
$karyawanLemburData = getAllLemburData();

// Proses data lembur ke dalam array tanggal
$lemburDates = [];
foreach ($karyawanLemburData as $lembur) {
    $lemburDates[$lembur['tanggal_pengajuan']] = true;
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
        <h6 class="card-subtitle">Sistem Lembur, Home Care</h6>
      </div>
    </div>
  </div>
</div>

<div class="row mb-4">
  <!-- Data Lembur -->
  <div class="col">
    <div class="card d-flex flex-column h-100">
      <div class="card-header">
        Data Lembur Semua Karyawan
      </div>
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
          </div>
        </form>
      </div>
      <div class="card-body">
        <div class="calendar">
          <?php foreach ($dates as $date): ?>
          <div class="day <?= isset($lemburDates[$date]) ? 'lembur' : '' ?>">
            <?= (new DateTime($date))->format('j') ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
require_once '../../includes/footer.php';
?>