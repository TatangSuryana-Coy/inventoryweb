<!-- filepath: resources/views/Admin/MrpCtrlr/hapus.blade.php -->
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog">
        <form id="formHapus" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="MRP_CTRL_HAPUS">
                <input type="hidden" name="WRK_CNTR_HAPUS">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
                <div id="infoHapus"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="submit">Hapus</button>
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>