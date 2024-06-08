<?php
$page_title = "Data Karyawan";
require '../../../includes/header.php';

$mainTable = 'karyawan';
$joinTables = [
  ['jabatan', 'karyawan.id_jabatan = jabatan.id_jabatan']
];

$columns = 'karyawan.*, jabatan.nama_jabatan';
$orderBy = 'karyawan.tanggal_masuk DESC';

$data_karyawan = selectDataJoin($mainTable, $joinTables, $columns, "", $orderBy);
?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="fs-5 m-0">Data karyawan</h1>
  <button type="button" class="btn btn-primary btn-lg btn-icon btn-add" data-bs-toggle="modal"
    data-bs-target="#addModal">
    Tambah Data karyawan
  </button>
</div>
<table id="example" class="table nowrap table-hover" style="width:100%">
  <thead>
    <tr>
      <th>No.</th>
      <th colspan="5">Nama Karyawan</th>
      <th>Jabatan</th>
      <th>No. HP</th>
      <th>Tanggal Masuk</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($data_karyawan)) : ?>
    <tr>
      <td colspan="5">Tidak ada data</td>
    </tr>
    <?php else : ?>
    <?php $no = 1; ?>
    <?php foreach ($data_karyawan as $karyawan) : ?>
    <tr>
      <td class="text-start"><?= $no; ?></td>
      <td colspan="5" class="text-primary"><?= strtoupper($karyawan['nama_karyawan']); ?></td>
      <td><?= ucwords($karyawan['nama_jabatan']); ?></td>
      <td><?= $karyawan['no_hp']; ?></td>
      <td><?= $karyawan['tanggal_masuk']; ?></td>
      <td>
        <div class="btn-group">
          <button type="button" class="btn-act btn-edit bg-transparent" data-bs-toggle="modal"
            data-bs-target="#editModal<?= $karyawan['id_karyawan']; ?>" title="Ubah Data"></button>
          <a href="javascript:void(0);"
            onclick="confirmDelete('del.php?id=<?= $karyawan['id_karyawan']; ?>', 'Apakah Anda yakin ingin menghapus data ini? Data yang sudah dihapus tidak dapat dikembalikan.')"
            class="btn-act btn-del" title="Hapus Data"></a>
        </div>
      </td>
    </tr>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal<?= $karyawan['id_karyawan']; ?>" data-bs-backdrop="static" tabindex="-1"
      aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="editModalLabel">Edit Data karyawan</h1>
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
require '../../../includes/footer.php';
?>