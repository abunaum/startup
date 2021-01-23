<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <div class="container-fluid">
            <div class="woocommerce columns-5">
                <div class="products" style="justify-content: center">
                    <?php foreach ($produk as $produk) : ?>
                        <div class="product-featured product" style="background-color: #e8ebed;">
                            <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="<?= base_url('user/toko/produk/detail') . '/' . $produk['id'] ?>">
                                <img width="224" height="197" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="<?= base_url() ?>/img/produk/<?= $produk['gambar']; ?>" alt="Gambar">
                                <p class="card-text"><?= $produk['nama'] ?></p>
                                <span class="price">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">Rp </span><?= number_format($produk['harga']); ?></span>
                                </span>
                            </a>
                            <!-- .woocommerce-LoopProduct-link -->
                            <hr>
                            <form action="<?= base_url('user/toko/produk/hapus') . '/' . $produk['id'] ?>" method="post">
                                <?= csrf_field() ?>
                                <button type="submit" class="btnhilang">
                                    <span class="iconify" data-icon="ic:baseline-delete-forever" data-inline="false" style="color: red;" data-width="25" data-height="25"></span>
                                </button>
                            </form>
                            <!-- .hover-area -->
                        </div>
                    <?php endforeach; ?>
                </div>
                <?= $pager->links(); ?>
                <!-- .products -->
            </div>
        </div>
    </div>
    <!-- .col-full -->
</section>
<?= $this->endSection(); ?>