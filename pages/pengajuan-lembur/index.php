<?php
$page_title = "Data Lembur";
require '../../includes/header.php';

$id_karyawan_log = $karyawan_log['id_karyawan'];
// Ambil data pengajuan lembur berdasarkan id_karyawan
$conditions = "id_karyawan = ?";
$orderBy = 'pengajuan_lembur.tanggal_pengajuan DESC';
$bind_params = [
    [
        'type' => 's', // 's' untuk tipe string (UUID)
        'value' => $id_karyawan_log
    ]
];

$data_pengajuan_lembur = selectData('pengajuan_lembur', $conditions, $orderBy, "", $bind_params);
?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="fs-5 m-0">Data Lembur</h1>
  <button type="button" class="btn btn-primary btn-lg btn-icon btn-add" data-bs-toggle="modal"
    data-bs-target="#addModal">
    Buat Pengajuan Lembur
  </button>
</div>
<table id="example" class="table nowrap table-hover" style="width:100%">
  <thead>
    <tr>
      <th>No.</th>
      <th>ID Pengajuan</th>
      <th>Tanggal</th>
      <th>Status</th>
      <th>Waktu Mulai</th>
      <th>Waktu Selesai</th>
      <th>Durasi Lembur</th>
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
      <td class="text-primary"><?= $pengajuan['id_pengajuan']; ?></td>
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
      <td><?= ucwords($pengajuan['keterangan']) ?></td>
      <td>
        <div class="btn-group">
          <button type="button" class="btn-act btn-edit bg-transparent" data-bs-toggle="modal"
            data-bs-target="#editModal<?= $pengajuan['id_pengajuan']; ?>" title="Ubah Data"></button>
          <a href="javascript:void(0);"
            onclick="confirmDelete('del.php?id=<?= $pengajuan['id_pengajuan']; ?>', 'Apakah Anda yakin ingin menghapus data ini? Data yang sudah dihapus tidak dapat dikembalikan.')"
            class="btn-act btn-del" title="Hapus Data"></a>
        </div>
      </td>
    </tr>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal<?= $pengajuan['id_pengajuan']; ?>" data-bs-backdrop="static" tabindex="-1"
      aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="editModalLabel">Edit Pengajuan Lembur</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php include 'edit.php'; ?>
            <!-- Include file edit.php untuk konten modal edit -->
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