<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <?php if ($totalinv >= 1) : ?>
            <?php foreach ($invoice as $inv) : ?>
                <?php foreach ($inv['data'] as $produk) : ?>
                    <table class="shop_table shop_table_responsive cart">
                        <thead>
                            <tr>
                                <th class="product-image">Produk</th>
                                <th class="product-name">Nama</th>
                                <th class="product-price">Harga</th>
                                <th class="product-price">Jumlah</th>
                                <th class="product-price">Pesan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-title="gambar" class="product-price">
                                    <?php $gambar = $produk['gambar'] ?>
                                    <img style="height: 150px; width: 150px;" src="<?= base_url("img/produk/$gambar") ?>" alt="Produk" class="img-thumbnail">
                                </td>
                                <td data-title="Nama" class="product-price">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol"><?= $produk['nama_produk'] ?></span>
                                    </span>
                                </td>
                                <td data-title="Harga" class="product-price">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">@ x <?= number_format($produk['harga']) ?></span>
                                    </span>
                                </td>
                                <td data-title="Jumlah" class="product-price">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol"><?= $produk['jumlah'] ?></span>
                                    </span>
                                </td>
                                <td data-title="Pesan" class="product-price">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">
                                            <?php if ($produk['pesan'] == '') : ?>
                                                <p>Tidak ada pesan</p>
                                            <?php else : ?>
                                                <?= $produk['pesan'] ?>
                                            <?php endif; ?>
                                        </span>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php endforeach; ?>
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">Kode Invoice</th>
                            <th scope="col">Nominal</th>
                            <th scope="col">Fee</th>
                            <th scope="col">Metode Pembayaran</th>
                            <th scope="col">Total Bayar</th>
                            <th scope="col">Expired (auto delete)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $inv['kode'] ?></td>
                            <td>Rp. <?= number_format($inv['nominal']) ?></td>
                            <td>Rp. <?= number_format($inv['fee']) ?></td>
                            <td><?= $inv['metode'] ?></td>
                            <td>Rp. <?= number_format($inv['nominal'] + $inv['fee']) ?></td>
                            <td><?= $inv['expired'] . ' WIB' ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-12">
                        <form method="post" action="<?= base_url('user/order/bayar') . '/' . $inv['id'] ?>">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-success" style="width: 100%;">Bayar</button>
                    </div>
                    </form>
                </div>
                <hr style="border-top: 2px dashed green;">
            <?php endforeach; ?>
        <?php else : ?>
            <center>
                <div class="card w-75 mt-3 mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Mantap</h5>
                        <p class="card-text">Anda tidak mempunyai tagihan.</p>
                    </div>
                    <!-- .woocommerce -->
                </div>
            </center>
        <?php endif; ?>
    </div>
</section>
</div>
<?= $this->endSection(); ?>