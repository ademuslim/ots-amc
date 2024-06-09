<!-- Form untuk mengedit produk -->
<form action="process.php" method="POST">
  <!-- Perbarui nilai default dengan data yang ada -->
  <div class="row mb-3">
    <label for="nama_karyawan" class="col-sm-3 col-form-label">Nama Karyawan:</label>
    <div class="col-sm-9">
      <input type="text" class="auto-focus form-control form-control-sm" id="nama_karyawan" name="nama_karyawan"
        value="<?= $karyawan['nama_karyawan']; ?>">
    </div>
  </div>

  <!-- Input Edit Jabatan -->
  <div class="row mb-3">
    <label for="jabatan" class="col-sm-3 col-form-label">Jabatan:</label>
    <div class="col-sm-9">
      <select class="form-select form-select-sm" id="jabatan" name="jabatan" required>
        <option value="" selected disabled>-- Pilih Jabatan --</option>
        <?php
            // Ambil data jabatan dari tabel jabatan
          $jabatan = selectData("jabatan");

          foreach ($jabatan as $row_jabatan) {
            $selected = ""; // Variabel untuk menentukan apakah opsi saat ini harus dipilih

            // Tentukan jabatan mana yang akan menjadi default berdasarkan ID jabatan saat ini
            if ($row_jabatan['id_jabatan'] == $karyawan['id_jabatan']) {
                $selected = "selected";
            }
            echo '<option value="' . $row_jabatan['id_jabatan'] . '" ' . $selected . '>' . ucwords($row_jabatan['nama_jabatan']) . '</option>';
        }
        ?>
      </select>
      <div class="invalid-feedback">
        Harap pilih jabatan yang sesuai.
      </div>
    </div>
  </div>

  <!-- Tambahkan kontrol untuk nomor telepon -->
  <div class="row mb-3">
    <label for="telepon" class="col-sm-3 col-form-label">Telepon:</label>
    <div class="col-sm-9">
      <!-- Perbarui nilai default dengan data yang ada -->
      <input type="tel" class="form-control form-control-sm" id="telepon" name="telepon"
        value="<?= $karyawan['no_hp']; ?>" pattern="[0-9]{10,}" placeholder="Opsional">
    </div>
  </div>

  <!-- Input Edit Tanggal Masuk -->
  <div class="row mb-3">
    <label for="tanggal_masuk" class="col-sm-3 col-form-label">Tanggal Masuk</label>
    <div class="col-auto">
      <input type="date" class="form-control form-control-sm" id="tanggal_masuk" name="tanggal_masuk" required
        value="<?= $karyawan['tanggal_masuk'] ?>">
      <div class="invalid-feedback">
        Harap pilih tanggal masuk.
      </div>
    </div>
  </div>

  <!-- Tambahkan input hidden untuk mengirim ID karyawan yang akan diubah -->
  <input type="hidden" name="id_karyawan" value="<?= $karyawan['id_karyawan']; ?>">
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" name="edit">Simpan Perubahan</button>
</form>