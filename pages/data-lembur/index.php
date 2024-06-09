<?php
$page_title = "Data Lembur";
require '../../includes/header.php';

$data_pengajuan_lembur = selectData('pengajuan_lembur', "", "tanggal_pengajuan DESC, waktu_mulai ASC");
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
      <td><?= getStatusPengajuan($pengajuan['id_pengajuan']) ?></td>
      <td><?= date('H:i', strtotime($pengajuan['waktu_mulai'])) ?></td>
      <td><?= date('H:i', strtotime($pengajuan['waktu_selesai'])) ?></td>
      <td><?= calculateDuration($pengajuan['waktu_mulai'], $pengajuan['waktu_selesai']) ?></td>
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