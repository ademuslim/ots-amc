<!-- Form untuk mengedit produk -->
<form action="process.php" method="POST">
  <div class="row mb-3">
    <label for="nama_jabatan" class="col-sm-3 col-form-label">Nama Jabatan:</label>
    <div class="col-sm-9">
      <!-- Perbarui nilai default dengan data yang ada -->
      <input type="text" class="auto-focus form-control form-control-sm" id="nama_jabatan" name="nama_jabatan"
        value="<?php echo $jabatan['nama_jabatan']; ?>" required>
    </div>
  </div>
  <div class="row mb-3">
    <label for="harga_lembur" class="col-sm-3 col-form-label">Harga Lembur:</label>
    <div class="col-sm-9">
      <!-- Perbarui nilai default dengan data yang ada -->
      <input type="number" step="0.01" class="form-control form-control-sm" id="harga_lembur" name="harga_lembur"
        value="<?php echo $jabatan['harga_lembur']; ?>" required>
    </div>
  </div>

  <!-- Tambahkan input hidden untuk mengirim ID produk yang akan diubah -->
  <input type="hidden" name="id_jabatan" value="<?php echo $jabatan['id_jabatan']; ?>">

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" name="edit">Simpan Perubahan</button>
</form>