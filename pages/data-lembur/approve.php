<!-- Form Persetujuan Pengajuan Lembur -->
<?php
$disetujui_oleh = $karyawan_log['id_karyawan'];
?>
<form action="process.php" method="POST">
  <div class="mb-3">
    <label for="status" class="form-label">Status:</label>
    <select class="form-select" id="status" name="status" required>
      <option value="">Pilih Status</option>
      <option value="disetujui">Disetujui</option>
      <option value="ditolak">Ditolak</option>
    </select>
  </div>
  <input type="hidden" name="id_pengajuan" value="<?= $pengajuan['id_pengajuan'] ?>">
  <input type="hidden" name="disetujui_oleh" value="<?= $disetujui_oleh ?>">
  <button type="submit" class="btn btn-primary" name="approve">Simpan</button>
</form>