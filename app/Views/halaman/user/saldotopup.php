<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <!-- <center> -->
        <?php $trxp = array_column($transaksi, 'UNPAID'); ?>
        <?php foreach ($trxp[0] as $trxp) : ?>
            <table class="shop_table shop_table_responsive cart">
                <thead>
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th class="product-thumbnail">&nbsp;</th>
                        <th class="product-name">Jenis</th>
                        <th class="product-name">Order Number</th>
                        <th class="product-price">Nominal</th>
                        <th class="product-price">Metode Pembayaran</th>
                        <th class="product-quantity">Fee</th>
                        <th class="product-subtotal">Total</th>
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
                                <img width="180" height="180" alt="" class="wp-post-image" src="<?= base_url(); ?>/logotoko.png">
                                <div class="media-body align-self-center">
                                    <a href="<?= base_url('user/saldo') ?>"><?= $trxp['jenis'] ?></a>
                                </div>
                            </div>
                        </td>
                        <td data-title="Order Number" class="product-price">
                            <span class="woocommerce-Price-amount amount">
                                <span class="woocommerce-Price-currencySymbol"><i><?= $trxp['order_number'] ?></i></span>
                            </span>
                        </td>
                        <td data-title="Nominal" class="product-price">
                            <span class="woocommerce-Price-amount amount">
                                <span class="woocommerce-Price-currencySymbol">Rp.</span><?= number_format($trxp['nominal']) ?>
                            </span>
                        </td>
                        <td data-title="Metode Pembayaran" class="product-price">
                            <span class="woocommerce-Price-amount amount">
                                <span class="woocommerce-Price-currencySymbol"><?= $trxp['metode'] ?>
                                </span>
                        </td>
                        <td data-title="Fee" class="product-price">
                            <span class="woocommerce-Price-amount amount">
                                <span class="woocommerce-Price-currencySymbol">Rp.</span><?= number_format($trxp['fee']) ?>
                            </span>
                        </td>
                        <td data-title="Total" class="product-subtotal">
                            <span class="woocommerce-Price-amount amount">
                                <span class="woocommerce-Price-currencySymbol">Rp</span><?= number_format($trxp['nominal'] + $trxp['fee']) ?>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-6">
                    <form action="<?= base_url('user/transaksisaldo/hapus') . '/' . $trxp['id'] ?>" method="post" id="hapustransaksi">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-danger tmbl-hps" style="width: 100%;" data-nama="<?= $trxp['order_number'] ?>">Hapus</button>
                    </form>
                </div>
                <div class="col-6">
                    <form method="post" action="<?= base_url('user/topup/prosess') . '/' . $trxp['id'] ?>">
                        <button type="submit" class="btn btn-success" style="width: 100%;">Bayar</button>
                </div>
                </form>
            </div>
            <!-- .shop_table shop_table_responsive -->
            <hr style="border-top: 2px dashed green;">
        <?php endforeach; ?>
        <!-- .cart-collaterals -->
        <!-- </center> -->
    </div>
    <!-- .col-full -->
</section>
</div>
<?= $this->endSection(); ?>