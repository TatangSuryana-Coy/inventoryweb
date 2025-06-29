<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="formEdit" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Part Label</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Error alert -->
                <div id="errorEdit" class="alert alert-danger d-none mx-3 mt-3"></div>
                <div class="modal-body row">
                    <div class="col-md-6">
                        <div class="form-group"><label>WERKS</label><input type="text" name="WERKS" class="form-control"></div>
                        <div class="form-group"><label>MATNR</label><input type="text" name="MATNR" class="form-control" readonly></div>
                        <div class="form-group"><label>MAKTX</label><input type="text" name="MAKTX" class="form-control"></div>
                        <div class="form-group"><label>ARBPL</label><input type="text" name="ARBPL" class="form-control"></div>
                        <div class="form-group"><label>VORNR</label><input type="text" name="VORNR" class="form-control"></div>
                        <div class="form-group"><label>EXTWG</label><input type="text" name="EXTWG" class="form-control"></div>
                        <div class="form-group"><label>LTXA1W</label><input type="text" name="LTXA1W" class="form-control"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>ZZP_NUM_ENT</label><input type="number" step="any" name="ZZP_NUM_ENT" class="form-control"></div>
                        <div class="form-group"><label>BUN</label><input type="text" name="BUN" class="form-control"></div>
                        <div class="form-group"><label>MRP</label><input type="text" name="MRP" class="form-control"></div>
                        <div class="form-group"><label>PLANT</label><input type="text" name="PLANT" class="form-control"></div>
                        <div class="form-group"><label>LNNM</label><input type="text" name="LNNM" class="form-control"></div>
                        <div class="form-group"><label>VSBL</label><input type="text" name="VSBL" maxlength="1" class="form-control"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnSimpanEdit">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Update
                    </button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>