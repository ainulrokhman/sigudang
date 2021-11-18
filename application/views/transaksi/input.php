<?php date_default_timezone_set('Asia/Jakarta'); ?>
<div class="col-lg-10 col-sm-12 mx-auto">
    <div class="card mb-3">
        <div class="card-header text-center">
            <h1 class="mb-3">Input Transaksi</h1>
        </div>
        <div class="card-body">
            <div class="alert alert-info" role="alert">Data yang telah diinputkan hanya dapat diubah/dihapus oleh admin</div>
            <?= $this->session->flashdata('notify') ?>
        </div>
    </div>
    <form class="user" action="<?= base_url('transaksi/input'); ?>" method="POST">
        <div class="card border-secondary mb-3">
            <div class="card-header text-white text-center bg-dark">Data Marketing</div>
            <div class="card-body">
                <div class="form-group row mx-3">
                    <div class="col-lg-2 col-sm-12">
                        <label for="id_marketing" class="col-form-label"><span class="text-danger">*)</span> Nama :</label>
                    </div>
                    <div class="col-lg-10 col-sm-12">
                        <select type="text" class="form-control" id="id_marketing" name="id_marketing">
                            <option value="" selected disabled>Pilih Marketing</option>
                            <?php foreach ($marketing as $mrk) : ?>
                                <?php if ($mrk['nama'] === $nama) : ?>
                                    <option value="<?= $mrk['id']; ?>" <?= $mrk['id'] == set_value('id_marketing') ? 'selected' : ''; ?>><?= $mrk['nama']; ?> (Manager)</option>
                                <?php else : ?>
                                    <option value="<?= $mrk['id']; ?>" <?= $mrk['id'] == set_value('id_marketing') ? 'selected' : ''; ?>><?= $mrk['nama']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('id_marketing', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-secondary mb-3">
            <div class="card-header text-white text-center bg-dark">Data Konsumen</div>
            <div class="card-body">
                <div class="form-group row mx-3">
                    <div class="col-lg-2 col-sm-12">
                        <label for="konsumen" class="col-form-label"><span class="text-danger">*)</span> Nama :</label>
                    </div>
                    <div class="col-lg-10 col-sm-12">
                        <input type="text" class="form-control" id="konsumen" name="konsumen" value="<?= set_value('konsumen'); ?>" autocomplete="off">
                        <?= form_error('konsumen', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row mx-3">
                    <div class="col-lg-2 col-sm-12">
                        <label for="telp_konsumen" class="col-form-label"><span class="text-danger">*)</span> No HP :</label>
                    </div>
                    <div class="col-lg-10 col-sm-12">
                        <input type="text" class="form-control" id="telp_konsumen" name="telp_konsumen" value="<?= set_value('telp_konsumen'); ?>" autocomplete="off">
                        <?= form_error('telp_konsumen', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row mx-3">
                    <div class="col-lg-2 col-sm-12">
                        <label for="alamat_konsumen" class="col-form-label"><span class="text-danger">*)</span> Alamat :</label>
                    </div>
                    <div class="col-lg-10 col-sm-12">
                        <textarea type="text" class="form-control" id="alamat_konsumen" name="alamat_konsumen" value="<?= set_value('alamat_konsumen'); ?>" rows="5"><?= set_value('alamat_konsumen'); ?></textarea>
                        <?= form_error('alamat_konsumen', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-secondary mb-3">
            <div class="card-header text-white text-center bg-dark">Data Transaksi</div>
            <div class="card-body">
                <div class="form-group row mx-3">
                    <div class="col-lg-2 col-sm-12">
                        <label for="gudang" class="col-form-label"><span class="text-danger">*)</span> Gudang :</label>
                    </div>
                    <div class="col-lg-10 col-sm-12">
                        <select name="gudang" id="gudang" class="form-control">
                            <option value="" selected disabled>Pilih Lokasi Gudang</option>
                            <?php foreach ($gudang as $gd) : ?>
                                <option value="<?= $gd['id']; ?>" <?= $gd['id'] == set_value('gudang') ? 'selected' : ''; ?>><?= $gd['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('gudang', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <!-- <div class="form-group row mx-3">
                    <label for="tanggal" class="col-form-label">Tanggal :</label>
                    <input type="text" class="form-control" id="tanggal" name="tanggal" autocomplete="off">
                </div> -->
                <div class="form-group row mx-3">
                    <div class="col-lg-2 col-sm-12">
                        <label for="nama_obat" class="col-form-label"><span class="text-danger">*)</span> Nama Obat :</label>
                    </div>
                    <div class="col-lg-10 col-sm-12">
                        <input type="text" class="form-control" id="nama_obat" name="nama_obat" value="<?= set_value('nama_obat'); ?>" autocomplete="off">
                        <?= form_error('nama_obat', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row mx-3">
                    <div class="col-lg-2 col-sm-12">
                        <label for="expedisi" class="col-form-label"><span class="text-danger">*)</span> Expedisi :</label>
                    </div>
                    <div class="col-lg-10 col-sm-12">
                        <input type="text" class="form-control" id="expedisi" name="expedisi" value="<?= set_value('expedisi'); ?>" autocomplete="off">
                        <?= form_error('expedisi', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row mx-3">
                    <div class="col-lg-2 col-sm-12">
                        <label for="no_resi" class="col-form-label"><span class="text-danger">*)</span> No Resi :</label>
                    </div>
                    <div class="col-lg-10 col-sm-12">
                        <input type="text" class="form-control" id="no_resi" name="no_resi" value="<?= set_value('no_resi'); ?>" autocomplete="off">
                        <?= form_error('no_resi', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="form-group row mx-3">
                    <div class="col-lg-2 col-sm-12">
                        <label for="catatan" class="col-form-label"><span class="text-info">ops</span> Catatan :</label>
                    </div>
                    <div class="col-lg-10 col-sm-12">
                        <textarea type="text" class="form-control" id="catatan" name="catatan"><?= set_value('catatan'); ?></textarea>
                        <?= form_error('catatan', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success btn-block">
            Submit
        </button>
    </form>
</div>