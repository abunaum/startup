<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <!-- .section-header -->
        <div class="categories-filter-products">
            <div class="woocommerce columns-4">
                <div class="products">
                    <?php foreach ($produk as $p) : ?>
                        <div class="product-featured product">
                            <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single-product-fullwidth.html">
                                <img width="224" height="197" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="<?= base_url() ?>/img/produk/<?= $p['gambar']; ?>" alt="Gambar">
                                <span class="price">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">Rp </span><?= number_format($p['harga']); ?></span>
                                </span>
                                <!-- .price -->
                                <h2 class="woocommerce-loop-product__title"><?= $p['nama']; ?></h2>
                                <?php
                                $db = \Config\Database::connect();
                                $owner = $db->table('users');
                                $owner->where('id', $p['owner']);
                                $owner = $owner->get()->getFirstRow();
                                $toko = $db->table('toko');
                                $toko->where('username_user', $owner->username);
                                $toko = $toko->get()->getFirstRow();
                                ?>
                                <h2 class="woocommerce-loop-product__title"><i>@<?= $toko->username; ?></i></h2>
                            </a>
                            <!-- .woocommerce-LoopProduct-link -->
                            <div class="hover-area">
                                <a class="button" href="cart.html">Detail</a>
                                <a class="button" href="cart.html">Beli</a>
                            </div>
                            <!-- .hover-area -->
                        </div>
                    <?php endforeach; ?>
                </div>
                <?= $pager->links(); ?>
                <!-- .products -->
            </div>
            <!-- .woocommerce -->

        </div>
        <!-- .categories-filter-products -->
    </div>
    <!-- .col-full -->
</section>
<?= $this->endSection(); ?>