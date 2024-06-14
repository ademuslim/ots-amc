<?php
$page_title = "Data Lembur";
require '../../includes/header.php';

$mainTable = 'pengajuan_lembur';
$joinTables = [
  ['karyawan', 'pengajuan_lembur.id_karyawan = karyawan.id_karyawan'],
  ['jabatan', 'karyawan.id_jabatan = jabatan.id_jabatan']
];

$columns = 'pengajuan_lembur.*, karyawan.nama_karyawan, jabatan.harga_lembur';
$orderBy = 'pengajuan_lembur.tanggal_pengajuan DESC';

$data_pengajuan_lembur = selectDataJoin($mainTable, $joinTables, $columns, "", $orderBy);

// $data_pengajuan_lembur = selectData('pengajuan_lembur', "", "tanggal_pengajuan DESC, waktu_mulai ASC");
?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="fs-5 m-0">Data Lembur</h1>

  <?php if ($_SESSION['peran_pengguna'] === 'pic'): ?>
  <button type="button" class="btn btn-primary btn-lg btn-icon btn-add" data-bs-toggle="modal"
    data-bs-target="#addModal">
    Buat Pengajuan Lembur
  </button>
  <?php endif; ?>
</div>

<table id="example" class="table nowrap table-hover" style="width:100%">
  <thead>
    <tr>
      <th>No.</th>
      <th>ID Pengajuan</th>
      <th>Nama Karyawan</th>
      <th>Tanggal</th>
      <th>Status</th>
      <th>Waktu Mulai</th>
      <th>Waktu Selesai</th>
      <th>Durasi Lembur</th>
      <th>Harga Lembur / Jam</th>
      <th>Total Harga Lembur</th>
      <th>Keterangan</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($data_pengajuan_lembur)) : ?>
    <tr>
      <td colspan="8">Tidak ada data</td>
    </tr>
    <?php else : ?>
    <?php $no = 1; ?>
    <?php foreach ($data_pengajuan_lembur as $pengajuan) : ?>
    <tr>
      <td class="text-start"><?= $no; ?></td>
      <td><?= $pengajuan['id_pengajuan']; ?></td>
      <td class="text-primary"><?= ucwords($pengajuan['nama_karyawan']); ?></td>
      <td><?= dateID($pengajuan['tanggal_pengajuan']) ?></td>

      <td>
        <?php
          // Tentukan kelas bootstrap berdasarkan nilai status
          $status_class = '';
          $status_value = getStatusPengajuan($pengajuan['id_pengajuan']);
          if ($status_value == 'pending') {
              $status_class = 'text-bg-warning';
          } elseif ($status_value == 'ditolak') {
              $status_class = 'text-bg-danger';
          } elseif ($status_value == 'disetujui') {
              $status_class = 'text-bg-success';
          }
        ?>
        <span class="badge <?= $status_class ?>"><?= ucfirst($status_value) ?></span>
      </td>

      <td><?= date('H:i', strtotime($pengajuan['waktu_mulai'])) ?></td>
      <td><?= date('H:i', strtotime($pengajuan['waktu_selesai'])) ?></td>
      <td><?= calculateDuration($pengajuan['waktu_mulai'], $pengajuan['waktu_selesai']) ?></td>
      <td><?= htmlspecialchars(number_format($pengajuan['harga_lembur'], 0, ',', '.')) ?></td>
      <td>
        <?php
        $durasiJamBulat = calculateRoundedDuration($pengajuan['waktu_mulai'], $pengajuan['waktu_selesai']);
        $totalHargaLembur = $durasiJamBulat * $pengajuan['harga_lembur'];
        echo htmlspecialchars(number_format($totalHargaLembur, 0, ',', '.'));
      ?>
      </td>
      <td><?= ucwords($pengajuan['keterangan']) ?></td>

      <?php if ($_SESSION['peran_pengguna'] === 'staff'): ?>
      <td>
        <div class="btn-group">
          <button type="button" class="btn-act btn-approve bg-transparent" data-bs-toggle="modal"
            data-bs-target="#approveModal<?= $pengajuan['id_pengajuan']; ?>" title="Setujui Pengajuan"></button>
          <a href="javascript:void(0);"
            onclick="confirmDelete('del.php?id=<?= $pengajuan['id_pengajuan']; ?>', 'Apakah Anda yakin ingin menghapus data ini? Data yang sudah dihapus tidak dapat dikembalikan.')"
            class="btn-act btn-del" title="Hapus Data"></a>
        </div>
      </td>
      <?php endif; ?>
    </tr>

    <!-- Modal Approve -->
    <div class="modal fade" id="approveModal<?= $pengajuan['id_pengajuan']; ?>" data-bs-backdrop="static" tabindex="-1"
      aria-labelledby="approveModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="approveModalLabel">Setujui Pengajuan Lembur</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php include 'approve.php'; ?>
            <!-- Include file approve.php untuk konten modal persetujuan -->
          </div>
        </div>
      </div>
    </div>
    <?php $no++; ?>
    <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

<?php
// Add Modal
require 'add.php';
require '../../includes/footer.php';
?>