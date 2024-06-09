<!-- Modal -->
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addModalLabel">Buat Pengajuan Lembur</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="process.php" method="POST">

          <!-- Input Karyawan -->
          <input type="hidden" name="id_karyawan" value="<?= $karyawan_log['id_karyawan'] ?>">

          <div class="row justify-content-between align-items-end">
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Nama Karyawan:</label>
              <div class="col-sm-9">
                <input type="text" class="auto-focus form-control form-control-sm"
                  value="<?= ucwords($karyawan_log['nama_karyawan']) ?>" readonly required>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Jabatan:</label>
              <div class="col-sm-9">
                <input type="text" class="auto-focus form-control form-control-sm"
                  value="<?= ucwords($karyawan_log['nama_jabatan']) ?>" readonly required>
              </div>
            </div>

            <!-- Input Tanggal Pengajuan -->
            <div class="row mb-3">
              <label for="tanggal_pengajuan" class="col-sm-3 col-form-label">Tanggal Pengajuan:</label>
              <div class="col-sm-9">
                <input type="date" class="form-control form-control-sm" id="tanggal_pengajuan" name="tanggal_pengajuan"
                  required>
              </div>
            </div>

            <!-- Input Waktu Mulai Lembur -->
            <div class="row mb-3">
              <label for="waktu_mulai" class="col-sm-3 col-form-label">Waktu Mulai:</label>
              <div class="col-sm-9">
                <input type="time" class="form-control form-control-sm" id="waktu_mulai" name="waktu_mulai" required>
              </div>
            </div>

            <!-- Input Waktu Selesai Lembur -->
            <div class="row mb-3">
              <label for="waktu_selesai" class="col-sm-3 col-form-label">Waktu Selesai:</label>
              <div class="col-sm-9">
                <input type="time" class="form-control form-control-sm" id="waktu_selesai" name="waktu_selesai"
                  required>
              </div>
            </div>

            <!-- Input Alasan Lembur -->
            <div class="row mb-3">
              <label for="alasan" class="col-sm-3 col-form-label">Alasan Lembur:</label>
              <div class="col-sm-9">
                <textarea class="form-control form-control-sm" id="alasan" name="alasan" rows="3" required></textarea>
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