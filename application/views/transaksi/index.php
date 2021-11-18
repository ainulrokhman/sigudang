<table class="table">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Marketing</th>
            <th>Konsumen</th>
            <th>Obat</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transaksi as $trx) : ?>
            <tr>
                <td><?= $trx['tanggal']; ?></td>
                <td><?= $trx['marketing']; ?></td>
                <td><?= $trx['konsumen']; ?></td>
                <td><?= $trx['nama_obat']; ?></td>
                <td>
                    <a href="<?= base_url('transaksi/detail/' . $trx['id']); ?>">
                        <span role="button" class="badge badge-info">detail</span>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>