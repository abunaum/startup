<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <!-- .section-header -->
        <?php if (count($produk) >= 1) : ?>
            <div class="categories-filter-products">
                <div class="woocommerce columns-10">
                    <div class="products d-flex justify-content-center">
                        <?php foreach ($produk as $p) : ?>
                            <div class="product">
                                <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="<?= base_url('produk/detail') . '/' . $p['id'] ?>">
                                    <img style="height: 150px; width: 150px;" class="img-thumbnail" src="<?= base_url(); ?>/img/produk/<?= $p['gambar']; ?>" alt="Gambar">
                                    <span class="price">
                                        <span class="woocommerce-Price-amount amount">
                                            <span class="woocommerce-Price-currencySymbol">Rp </span><?= number_format($p['harga']); ?></span>
                                    </span>
                                    <!-- .price -->
                                    <h2 class="woocommerce-loop-product__title"><?= $p['nama']; ?></h2>
                                    <h2 class="woocommerce-loop-product__title"><i>@<?= $p['username']; ?></i></h2>
                                </a>
                                <!-- .woocommerce-LoopProduct-link -->
                                <div class="hover-area flex-row justify-content-center">
                                    <a class="button" href="<?= base_url('produk/detail') . '/' . $p['id'] ?>">Detail</a>
                                    <?php if ($p['status'] == 1) : ?>
                                        <?php if (logged_in() == true) : ?>
                                            <a class="button">Beli</a>
                                        <?php else : ?>
                                            <a class="button">Login & Beli</a>
                                        <?php endif; ?>
                                    <?php endif; ?>
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