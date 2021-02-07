<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <div class="row">
            <!-- .woocommerce-breadcrumb -->
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <div class="product product-type-simple">
                        <center>
                            <div class="single-product-wrapper">
                                <!-- .product-images-wrapper -->
                                <div class="summary entry-summary">
                                    <div class="single-product-header">
                                        <h2 class="product_title entry-title"><?= $produk->nama; ?></h2>
                                    </div>
                                    <!-- .single-product-header -->
                                    <div class="single-product-meta">
                                        <div class="brand">
                                            <img width="224" height="197" class="attachment-shop_catalog size-shop_catalog wp-post-image" alt="gambar" src="<?= base_url(); ?>/img/produk/<?= $produk->gambar; ?>">
                                        </div>
                                    </div>
                                    <br>
                                    <!-- .single-product-meta -->
                                    <div class="rating-and-sharing-wrapper">
                                        <div class="woocommerce-product-rating">
                                            <span class="fa fa-star" style="color: orange;"></span>
                                        </div>
                                    </div>
                                    <p><i>Stok : <?= $produk->stok; ?></i></p>
                                    <!-- .rating-and-sharing-wrapper -->
                                    <div class="woocommerce-product-details__short-description">
                                        <p style="white-space: pre-line">
                                            <?= $produk->keterangan; ?>
                                        </p>
                                    </div>
                                    <!-- .woocommerce-product-details__short-description -->
                                    <div class="product-actions-wrapper">
                                        <div class="product-actions">
                                            <p class="price">
                                                <ins>
                                                    <span class="woocommerce-Price-amount amount">
                                                        <span class="woocommerce-Price-currencySymbol">Rp.</span><?= number_format($produk->harga); ?></span>
                                                </ins>
                                            </p>
                                            <!-- .single-product-header -->
                                            <form action="<?= base_url('user/toko/produk/hapus').'/'.$produk->id; ?>"  method="post" class="cart">
                                                <button type="button" class="btn btn-danger tmbl-hps" data-nama="<?= $produk->nama; ?>">Hapus</button>
                                            </form>
                                        </div>
                                        <!-- .product-actions -->
                                    </div>
                                    <!-- .product-actions-wrapper -->
                                </div>
                                <!-- .entry-summary -->
                            </div>
                        </center>
                        <hr style="border-top: 2px dashed green;">
                        <!-- .single-product-wrapper -->
                        <div class="tm-related-products-carousel section-products-carousel">
                            <section class="related">
                                <header class="section-header">
                                    <h2 class="section-title">Produk Toko</h2>
                                    <nav class="custom-slick-nav"></nav>
                                </header>
                                <!-- .section-header -->
                                <div class="products">
                                    <?php foreach ($produkuser as $pu) : ?>
                                        <div class="product">
                                            <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="<?= base_url('/user/toko/produk/detail').'/'.$pu['id']; ?>">
                                                <img width="224" height="197" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="<?= base_url(); ?>/img/produk/<?= $pu['gambar']; ?>" alt="Gambar">
                                                <span class="price">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <span class="woocommerce-Price-currencySymbol">Rp </span><?= number_format($pu['harga']); ?></span>
                                                </span>
                                                <!-- .price -->
                                                <h2 class="woocommerce-loop-product__title"><?= $pu['nama']; ?></h2>
                                                <h2 class="woocommerce-loop-product__title"><i>@<?= $toko->username; ?></i></h2>
                                            </a>
                                            <!-- .woocommerce-LoopProduct-link -->
                                            <div class="hover-area">
                                                <a class="button" href="<?= base_url('/user/toko/produk/detail').'/'.$pu['id']; ?>">Detail</a>
                                            </div>
                                            <!-- .hover-area -->
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </section>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>