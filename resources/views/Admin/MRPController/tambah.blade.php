<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form id="formTambah" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="errorTambah" class="alert alert-danger d-none"></div>
                <div class="mb-2"><label>MRP_CTRL</label><input type="text" name="MRP_CTRL" class="form-control" maxlength="4" required></div>
                <div class="mb-2"><label>WRK_CNTR</label><input type="text" name="WRK_CNTR" class="form-control" maxlength="7" required></div>
                <div class="mb-2"><label>MRP_NAME</label><input type="text" name="MRP_NAME" class="form-control" maxlength="30" required></div>
                <div class="mb-2"><label>PLANT</label><input type="text" name="PLANT" class="form-control" maxlength="5" required></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>
