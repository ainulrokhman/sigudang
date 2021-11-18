<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header text-center">
        <h2 class="m-0 font-weight-bold text-primary">Data Transaksi</h2>
    </div>
    <div class="card-body">
        <div class="form-group row">
            <div class="col-lg-6 col-xm-12 text-right">
                <label for="filter" class="col-form-label">Tanggal Pengiriman</label>
            </div>
            <div class="col-lg-6 col-xm-12">
                <input type="text" class="form-control col-lg-10 col-sm-12" id="tanggal" name="nama_obat" value="<?= date('m-d-Y'); ?>" autocomplete="off">
            </div>
        </div>
        <div class="table-responsive-sm">
            <hr>
            <table style="font-size: 13px;" class="table table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Gudang</th>
                        <th>Marketing</th>
                        <th>Hp</th>
                        <th>Konsumen</th>
                        <th>Hp</th>
                        <th>Alamat</th>
                        <th>Obat</th>
                        <th>Expedisi</th>
                        <th>Resi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>