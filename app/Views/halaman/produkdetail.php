<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="mb-5 stretch-full-width">
    <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
    <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
    <div class="col-full">
        <div class="row mb-3">
            <div class="col-md-4 mb-4 mb-md-0">
                <div id="mdb-lightbox-ui"></div>
                <div class="mdb-lightbox">
                    <div class="row product-gallery mx-1">
                        <div class="col-12 mb-0">
                            <figure class="view overlay rounded z-depth-1 main-img">
                                <img src="<?= base_url(); ?>/img/produk/<?= $produk->gambar; ?>" class="img-thumbnail z-depth-1">
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-3" style="background-color: #dce0e0;">
                <center class="mt-3">
                    <h5><?= $produk->nama; ?></h5>
                    <p class="text-muted text-uppercase small">
                        <i>Stok : <?= $produk->stok; ?></i>
                    </p>
                    <p class="text-muted text-uppercase small">
                        Store : <i>@<?= $produk->toko_username; ?></i>
                    </p>
                    <div>
                        <span class="iconify" data-icon="emojione:star" data-inline="false"></span>
                        <span class="iconify" data-icon="emojione:star" data-inline="false"></span>
                        <span class="iconify" data-icon="emojione:star" data-inline="false"></span>
                        <span class="iconify" data-icon="emojione:star" data-inline="false"></span>
                        <span class="iconify" data-icon="emojione:star" data-inline="false"></span>
                    </div>
                    <p>
                        <span>
                            <strong>Rp. <?= number_format($produk->harga); ?></strong>
                        </span>
                    </p>
                    <p>
                        <?= nl2br($produk->keterangan) ?>
                    </p>
                    <hr>
                    <div class="mb-3">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#orderModal">Beli</button>
                    </div>
                </center>
            </div>
        </div>
        <hr class="mb-2" style="border-top: 2px dashed green;">
        <div class="tm-related-products-carousel section-products-carousel">
            <section class="related">
                <header class="section-header">
                    <h2 class="section-title">Produk Toko</h2>
                    <nav class="custom-slick-nav"></nav>
                </header>

                <div class="products">
                    <?php foreach ($produktoko as $pu) : ?>
                        <div class="product">
                            <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="<?= base_url('/user/toko/produk/detail') . '/' . $pu['id']; ?>">
                                <img style="height: 150px; width: 150px;" class="img-thumbnail" src="<?= base_url(); ?>/img/produk/<?= $pu['gambar']; ?>" alt="Gambar">
                                <span class="price">
                                    <span class="woocommerce-Price-amount amount">
                                        <span class="woocommerce-Price-currencySymbol">Rp </span><?= number_format($pu['harga']); ?></span>
                                </span>

                                <h2 class="woocommerce-loop-product__title"><?= $pu['nama']; ?></h2>
                                <h2 class="woocommerce-loop-product__title"><i>@<?= $produk->toko_username; ?></i></h2>
                            </a>

                            <div class="hover-area">
                                <a class="button" href="<?= base_url('produk/detail') . '/' . $pu['id']; ?>">Detail</a>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <center>
                                <h5 class="modal-title" id="orderModalLabel">Beli Produk</h5>
                            </center>
                            <button type="button" class="iconify" data-icon="clarity:window-close-line" data-inline="false" data-width="24px" data-height="24px" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form class="g-3 needs-validation" action="<?= base_url("order/$produk->id") ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="pesan">Pesan untuk penjual</label>
                                    <textarea class="form-control" id="pesan" name="pesan" rows="3" placeholder="ex : kirimkan segera"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="jumlah">Jumlah Order</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="1">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    <?php if (logged_in() == true) : ?>
                                        Beli
                                    <?php else : ?>
                                        Login & Beli
                                    <?php endif; ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>