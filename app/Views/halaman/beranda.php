<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <!-- .section-header -->
        <?php if (count($produk) >= 1) : ?>
            <div class="categories-filter-products">
                <div class="woocommerce columns-4">
                    <div class="products">
                        <?php foreach ($produk as $p) : ?>
                            <div class="product">
                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="single-product-fullwidth.html">
                                    <img width="224" height="197" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="<?= base_url() ?>/img/produk/<?= $p['gambar']; ?>" alt="Gambar">
                                    <span class="price">
                                        <span class="woocommerce-Price-amount amount">
                                            <span class="woocommerce-Price-currencySymbol">Rp </span><?= number_format($p['harga']); ?></span>
                                    </span>
                                    <!-- .price -->
                                    <h2 class="woocommerce-loop-product__title"><?= $p['nama']; ?></h2>
                                    <h2 class="woocommerce-loop-product__title"><i>@<?= $p['username']; ?></i></h2>
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
        <?php else : ?>
            <center>
                <div class="card w-75 mt-3 mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Ooops !</h5>
                        <p class="card-text">Produk yang anda cari tidak ada.</p>
                    </div>
                    <!-- .woocommerce -->
                </div>
            </center>
        <?php endif; ?>
        <!-- .categories-filter-products -->
    </div>
    <!-- .col-full -->
</section>
<?= $this->endSection(); ?>