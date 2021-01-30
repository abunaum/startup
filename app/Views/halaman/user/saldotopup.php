<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <center>
            <form method="post" action="<?= base_url('user/topup/prosess') . '/' . $transaksi->id ?>">
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
                                        <a href="<?= base_url('user/saldo') ?>"><?= $transaksi->jenis ?></a>
                                    </div>
                                </div>
                            </td>
                            <td data-title="Order Number" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol"><i><?= $transaksi->order_number ?></i></span>
                                </span>
                            </td>
                            <td data-title="Nominal" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">Rp.</span><?= number_format($transaksi->nominal) ?>
                                </span>
                            </td>
                            <td data-title="Metode Pembayaran" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol"><?= $transaksi->metode ?>
                                    </span>
                            </td>
                            <td data-title="Fee" class="product-price">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">Rp.</span><?= number_format($transaksi->fee) ?>
                                </span>
                            </td>
                            <td data-title="Total" class="product-subtotal">
                                <span class="woocommerce-Price-amount amount">
                                    <span class="woocommerce-Price-currencySymbol">Rp</span><?= number_format($transaksi->nominal + $transaksi->fee) ?>
                                </span>
                                <a title="Remove this item" class="remove" href="#">×</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="actions" colspan="6">
                                <button type="submit" name="update_cart" class="button">Bayar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- .shop_table shop_table_responsive -->
            </form>
            <!-- .cart-collaterals -->
    </div>
    </center>
    <!-- .col-full -->
</section>
</div>
<?= $this->endSection(); ?>