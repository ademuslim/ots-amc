<!-- master-data/product/add -->

<!-- Modal -->
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addModalLabel">Tambah Data Karyawan</h1>
        <!-- Perbarui judul modal dengan menggunakan kategori Karyawan -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="process.php" method="POST">

          <div class="row justify-content-between align-items-end">
            <div class="row mb-3">
              <label for="nama_karyawan" class="col-sm-3 col-form-label">Nama Karyawan:</label>
              <div class="col-sm-9">
                <input type="text" class="auto-focus form-control form-control-sm" id="nama_karyawan"
                  name="nama_karyawan" required>
              </div>
            </div>

            <!-- Input Jabatan -->
            <div class="row mb-3">
              <label for="jabatan" class="col-sm-3 col-form-label">Jabatan:</label>
              <div class="col-sm-9">
                <select class="form-select form-select-sm" id="jabatan" name="jabatan" required>
                  <option value="" selected disabled>-- Pilih Jabatan --</option>
                  <?php
                  // Ambil data jabatan dari tabel jabatan
                $jabatan = selectData("jabatan");

                // Loop untuk menampilkan data jabatan dalam dropdown
                foreach ($jabatan as $row_jabatan) {
                    echo '<option value="' . $row_jabatan['id_jabatan'] . '">' . ucwords($row_jabatan['nama_jabatan']) . '</option>';
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
                <input type="tel" class="form-control form-control-sm" id="telepon" name="telepon"
                  placeholder="Opsional" pattern="[0-9]{10,15}">
              </div>
            </div>

            <div class="row mb-3">
              <label for="tanggal_masuk" class="col-sm-3 col-form-label">Tanggal Masuk</label>
              <div class="col-auto">
                <input type="date" class="form-control form-control-sm" id="tanggal_masuk" name="tanggal_masuk"
                  required>
                <div class="invalid-feedback">
                  Harap pilih tanggal masuk.
                </div>
              </div>
            </div>

            <!-- Input Pengguna -->
            <div class="row mb-3">
              <label for="pengguna" class="col-sm-3 col-form-label">Nama Pengguna:</label>
              <div class="col-sm-9">
                <select class="form-select form-select-sm" id="pengguna" name="pengguna" required>
                  <option value="" selected disabled>-- Pilih Pengguna --</option>
                  <?php
                  // Ambil data pengguna dari tabel pengguna
                $pengguna = selectData("pengguna");

                // Loop untuk menampilkan data pengguna dalam dropdown
                foreach ($pengguna as $row_pengguna) {
                    echo '<option value="' . $row_pengguna['id_pengguna'] . '">' . $row_pengguna['nama_pengguna'] . '</option>';
                }
                ?>
                </select>
                <div class="invalid-feedback">
                  Harap pilih pengguna yang sesuai.
                </div>
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