<!-- Form Edit Data Pengajuan Lembur -->
<form action="process.php" method="POST">
  <div class="mb-3">
    <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan:</label>
    <input type="date" class="form-control" id="tanggal_pengajuan" name="tanggal_pengajuan"
      value="<?= date('Y-m-d', strtotime($pengajuan['tanggal_pengajuan'])); ?>" required>
  </div>
  <div class="mb-3">
    <label for="waktu_mulai" class="form-label">Waktu Mulai:</label>
    <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai"
      value="<?= date('H:i', strtotime($pengajuan['waktu_mulai'])); ?>" required>
  </div>
  <div class="mb-3">
    <label for="waktu_selesai" class="form-label">Waktu Selesai:</label>
    <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai"
      value="<?= date('H:i', strtotime($pengajuan['waktu_selesai'])); ?>" required>
  </div>
  <div class="mb-3">
    <label for="alasan" class="form-label">Keterangan:</label>
    <textarea class="form-control" id="alasan" name="alasan" rows="3"
      required><?= $pengajuan['keterangan']; ?></textarea>
  </div>
  <input type="hidden" name="id_pengajuan" value="<?= $pengajuan['id_pengajuan']; ?>">
  <button type="submit" class="btn btn-primary" name="edit">Simpan Perubahan</button>
</form>