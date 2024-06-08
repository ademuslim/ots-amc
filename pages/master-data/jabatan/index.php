<?php
$page_title = "Data Jabatan";
require '../../../includes/header.php';

$data_jabatan = selectData('jabatan');
?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1 class="fs-5 m-0">Data Jabatan</h1>
  <button type="button" class="btn btn-primary btn-lg btn-icon btn-add" data-bs-toggle="modal"
    data-bs-target="#addModal">
    Tambah Data Jabatan
  </button>
</div>
<table id="example" class="table nowrap table-hover" style="width:100%">
  <thead>
    <tr>
      <th>No.</th>
      <th colspan="5">Nama Jabatan</th>
      <th>Harga Lembur<a href="#" class="link-danger link-offset-2 link-underline-opacity-0" data-bs-toggle="tooltip"
          data-bs-custom-class="custom-tooltip" data-bs-title="Harga lembur per jam">*</a></th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($data_jabatan)) : ?>
    <tr>
      <td colspan="4">Tidak ada data</td>
    </tr>
    <?php else : ?>
    <?php $no = 1; ?>
    <?php foreach ($data_jabatan as $jabatan) : ?>
    <tr>
      <td class="text-start"><?= $no; ?></td>
      <td colspan="5" class="text-primary"><?= strtoupper($jabatan['nama_jabatan']); ?></td>
      <td><?= formatRupiah($jabatan['harga_lembur']); ?></td>
      <td>
        <div class="btn-group">
          <button type="button" class="btn-act btn-edit bg-transparent" data-bs-toggle="modal"
            data-bs-target="#editModal<?= $jabatan['id_jabatan']; ?>" title="Ubah Data"></button>
          <a href="javascript:void(0);"
            onclick="confirmDelete('del.php?id=<?= $jabatan['id_jabatan']; ?>', 'Apakah Anda yakin ingin menghapus data ini? Data yang sudah dihapus tidak dapat dikembalikan.')"
            class="btn-act btn-del" title="Hapus Data"></a>
        </div>
      </td>
    </tr>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal<?= $jabatan['id_jabatan']; ?>" data-bs-backdrop="static" tabindex="-1"
      aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="editModalLabel">Edit Data jabatan</h1>
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