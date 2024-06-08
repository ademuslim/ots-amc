<!-- master-data/product/add -->

<!-- Modal -->
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addModalLabel">Tambah Data Jabatan</h1>
        <!-- Perbarui judul modal dengan menggunakan kategori jabatan -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="process.php" method="POST">

          <div class="row justify-content-between align-items-end">
            <div class="row mb-3">
              <label for="nama_jabatan" class="col-sm-3 col-form-label">Nama jabatan:</label>
              <div class="col-sm-9">
                <input type="text" class="auto-focus form-control form-control-sm" id="nama_jabatan" name="nama_jabatan"
                  required>
              </div>
            </div>
            <div class="row mb-3">
              <label for="harga_lembur" class="col-sm-3 col-form-label">Harga Lembur:<a href="#"
                  class="link-danger link-offset-2 link-underline-opacity-0" data-bs-toggle="tooltip"
                  data-bs-custom-class="custom-tooltip" data-bs-title="Harga lembur per jam">*</a></label>
              <div class="col-sm-9">
                <input type="number" step="0.01" class="form-control form-control-sm" id="harga_lembur"
                  name="harga_lembur" required>
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