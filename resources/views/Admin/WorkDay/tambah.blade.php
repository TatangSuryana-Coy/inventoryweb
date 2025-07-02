<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form id="formTambah" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="errorTambah" class="alert alert-danger d-none"></div>
                <div class="mb-2">
                    <label>WorkDate</label>
                    <input type="date" name="WorkDate" class="form-control" required value="{{ date('Y-m-d') }}">
                </div>
                <div class="mb-2">
                    <label>StatusDay</label>
                    <select name="StatusDay" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Off Day">Off Day</option>
                        <option value="Work Day">Work Day</option>
                        <option value="Libur Minggu/Sabtu">Libur Minggu/Sabtu</option>
                    </select>
                </div>
                <div class="mb-2"><label>NoteDay</label><input type="text" name="NoteDay" class="form-control" maxlength="100"></div>
                <div class="mb-2"><label>StatusLabel</label><input type="text" name="StatusLabel" class="form-control" maxlength="50"></div>
                <div class="mb-2"><label>EXPDT</label><input type="number" name="EXPDT" class="form-control"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>