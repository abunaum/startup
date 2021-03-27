<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <?php foreach ($keranjang as $keranjang) : ?>
            <table class="shop_table shop_table_responsive cart">
                <thead>
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th class="product-thumbnail">&nbsp;</th>
                        <th class="product-name">Produk</th>
                        <th class="product-name">Store</th>
                        <th class="product-price">Harga</th>
                        <th class="product-price">Jumlah</th>
                        <th class="product-quantity">Pesan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="product-remove">
                            <a class="remove" href="#">×</a>
                        </td>
                        <td class="product-thumbnail">
                            <img width="180" height="180" alt="" class="wp-post-image" src="<?= base_url(); ?>/logotoko.png">
                        </td>
                        <td data-title="Product" class="product-name">
                            <div class="media cart-item-product-detail">
                                <img width="180" height="180" alt="" class="wp-post-image" src="<?= base_url('img/produk') . '/' . $keranjang['gambar_produk']; ?>">
                                <div class="media-body align-self-center">
                                    <a href="<?= base_url('produk/detail') . '/' . $keranjang['id_produk'] ?>">
                                        <strong><?= $keranjang['nama_produk'] ?></strong>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td data-title="Order Number" class="product-price">
                            <span class="woocommerce-Price-amount amount">
                                <span><i>@<?= $keranjang['nama_toko'] ?></i></span>
                            </span>
                        </td>
                        <td data-title="Nominal" class="product-price">
                            <span class="woocommerce-Price-amount amount">
                                <span class="woocommerce-Price-currencySymbol">Rp. </span><?= number_format($keranjang['harga_produk']) ?>
                            </span>
                        </td>
                        <td data-title="Jumlah Pesanan" class="product-price">
                            <span>
                                <?= $keranjang['jumlah'] ?>
                            </span>
                        </td>
                        <td data-title="Pesan ke penjual">
                            <span><?= $keranjang['pesan'] ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <hr style="border-top: 2px dashed green;">
        <?php endforeach; ?>
        <div class="row">
            <div class="col-6">
                <form action="<?= base_url('user/transaksisaldo/hapus') . '/' . $keranjang['id'] ?>" method="post" id="hapustransaksi">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-danger tmbl-hps" style="width: 100%;" data-nama="<?= $keranjang['nama_produk'] ?>">Hapus</button>
                </form>
            </div>
            <div class="col-6">
                <form method="post" action="<?= base_url('user/topup/prosess') . '/' . $keranjang['id'] ?>">
                    <button type="submit" class="btn btn-success" style="width: 100%;">Bayar</button>
            </div>
            </form>
        </div>
    </div>
</section>
</div>
<?= $this->endSection(); ?>