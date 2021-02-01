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
                                        <h1 class="product_title entry-title"><?= $produk->nama ?></h1>
                                    </div>
                                    <!-- .single-product-header -->
                                    <div class="single-product-meta">
                                        <div class="brand">
                                            <img alt="gambar" src="<?= base_url() ?>/img/produk/<?= $produk->gambar; ?>">
                                        </div>
                                    </div>
                                    <br>
                                    <!-- .single-product-meta -->
                                    <div class="rating-and-sharing-wrapper">
                                        <div class="woocommerce-product-rating">
                                            <div class="star-rating">
                                                <span style="width:100%">Rated
                                                    <strong class="rating">5.00</strong> out of 5 based on
                                                    <span class="rating">1</span> customer rating</span>
                                            </div>
                                            <a rel="nofollow" class="woocommerce-review-link" href="#reviews">(<span class="count">1</span> customer review)</a>
                                        </div>
                                    </div>
                                    <br>
                                    <!-- .rating-and-sharing-wrapper -->
                                    <div class="woocommerce-product-details__short-description">
                                        <?= $produk->keterangan ?>
                                    </div>
                                    <!-- .woocommerce-product-details__short-description -->
                                    <div class="product-actions-wrapper">
                                        <div class="product-actions">
                                            <p class="price">
                                                <ins>
                                                    <span class="woocommerce-Price-amount amount">
                                                        <span class="woocommerce-Price-currencySymbol">Rp.</span><?= number_format($produk->harga) ?></span>
                                                </ins>
                                            </p>
                                            <!-- .single-product-header -->
                                            <form method="post" class="cart">
                                                <button class="btn-success">Ubah</button>
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
                                    <h2 class="section-title">Related products</h2>
                                    <nav class="custom-slick-nav"></nav>
                                </header>
                                <!-- .section-header -->
                                <div class="products">
                                    <div class="product">
                                        <div class="yith-wcwl-add-to-wishlist">
                                            <a href="wishlist.html" rel="nofollow" class="add_to_wishlist"> Add to Wishlist</a>
                                        </div>
                                        <a href="single-product-fullwidth.html" class="woocommerce-LoopProduct-link">
                                            <img src="assets/images/products/5.jpg" width="224" height="197" class="wp-post-image" alt="">
                                            <span class="price">
                                                <ins>
                                                    <span class="amount"> </span>
                                                </ins>
                                                <span class="amount"> 456.00</span>
                                            </span>
                                            <!-- /.price -->
                                            <h2 class="woocommerce-loop-product__title">XONE Wireless Controller</h2>
                                        </a>
                                        <div class="hover-area">
                                            <a class="button add_to_cart_button" href="cart.html" rel="nofollow">Add to cart</a>
                                            <a class="add-to-compare-link" href="compare.html">Add to compare</a>
                                        </div>
                                    </div>
                                    <!-- /.product-outer -->
                                </div>
                            </section>
                            <!-- .single-product-wrapper -->
                        </div>
                        <!-- .brands-carousel -->
                    </div>
                    <!-- .product -->
                </main>
                <!-- #main -->
            </div>
            <!-- #primary -->
        </div>
    </div>
    <!-- .row -->
    <!-- .col-full -->
</section>
<?= $this->endSection(); ?>