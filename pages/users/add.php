<!-- master-data/user/add -->

<!-- Modal -->
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addModalLabel">Tambah Data Pengguna</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="process.php" method="POST">

          <!-- Input karyawan -->
          <div class="row mb-3">
            <label for="karyawan" class="col-sm-3 col-form-label">Nama Karyawan:</label>
            <div class="col-sm-9">
              <select class="form-select form-select-sm" id="karyawan" name="karyawan" required>
                <option value="" selected disabled>-- Pilih Karyawan --</option>
                <?php
                  // Ambil data karyawan dari tabel karyawan
                $karyawan = selectData("karyawan");

                // Loop untuk menampilkan data karyawan dalam dropdown
                foreach ($karyawan as $row_karyawan) {
                    echo '<option value="' . $row_karyawan['id_karyawan'] . '">' . ucwords($row_karyawan['nama_karyawan']) . '</option>';
                }
                ?>
              </select>
              <div class="invalid-feedback">
                Harap pilih karyawan yang sesuai.
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <label for="nama_pengguna" class="col-sm-3 col-form-label">Nama Pengguna:</label>
            <div class="col-sm-9">
              <input type="text" class="auto-focus form-control form-control-sm" id="nama_pengguna" name="nama_pengguna"
                required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="email" class="col-sm-3 col-form-label">Email:</label>
            <div class="col-sm-9">
              <input type="email" class="form-control form-control-sm" id="email" name="email" required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="password" class="col-sm-3 col-form-label">Password:</label>
            <div class="col-sm-9">
              <input type="password" class="form-control form-control-sm" id="password" name="password" required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="confirm_password" class="col-sm-3 col-form-label">Ulangi Password:</label>
            <div class="col-sm-9">
              <input type="password" class="form-control form-control-sm" id="confirm_password" name="confirm_password"
                required>
            </div>
          </div>

          <div class="row mb-3">
            <label for="tipe_pengguna" class="col-sm-3 col-form-label">Tipe Pengguna:</label>
            <div class="col-sm-9">
              <select class="form-select form-select-sm" id="tipe_pengguna" name="tipe_pengguna" required>
                <option value="staff">Staff</option>
                <option value="dept. head">Dept. Head</option>
                <option value="superadmin">Superadmin</option>
                <option value="pic">PIC</option>
              </select>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="add">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>