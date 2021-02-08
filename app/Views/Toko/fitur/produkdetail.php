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
                                    <div class="product-actions-wrapper mb-2">
                                        <div class="product-actions">
                                            <p class="price">
                                                <ins>
                                                    <span class="woocommerce-Price-amount amount">
                                                        <span class="woocommerce-Price-currencySymbol">Rp.</span><?= number_format($produk->harga); ?></span>
                                                </ins>
                                            </p>
                                            <!-- .single-product-header -->
                                            <form action="<?= base_url('user/toko/produk/hapus') . '/' . $produk->id; ?>" method="post" class="d-inline">
                                                <input type="hidden" name="_method" value="DELETE" />
                                                <button type="button" class="btn btn-danger tmbl-hps" data-nama="<?= $produk->nama; ?>">Hapus</button>
                                            </form>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">Edit</button>
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
                                            <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="<?= base_url('/user/toko/produk/detail') . '/' . $pu['id']; ?>">
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
                                                <a class="button" href="<?= base_url('/user/toko/produk/detail') . '/' . $pu['id']; ?>">Detail</a>
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
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Dagangan</h5>
            </div>
            <div class="modal-body">
                <center>
                    <form class="g-3 needs-validation" action="<?= base_url('user/toko/produk/edit') . '/' . $produk->id; ?>" enctype="multipart/form-data" method="post" novalidate>
                        <?= csrf_field(); ?>
                        <div class="mt-2">
                            <img class="ard-img-top rounded-circle col col-md-6 mb-3 lihat-gambar" alt="gambar" src="<?= base_url(); ?>/img/produk/<?= $produk->gambar; ?>">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" placeholder="Nama Produk" aria-label="nama" name="nama" id="nama" aria-describedby="basic-addon1" value="<?= (old('nama')) ? old('nama') : $produk->nama ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama'); ?>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"><?= (old('keterangan')) ? old('keterangan') : $produk->keterangan ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('keterangan'); ?>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                            <input type="number" class="form-control <?= ($validation->hasError('harga')) ? 'is-invalid' : '' ?>" placeholder="Harga" aria-label="harga" name="harga" id="harga" aria-describedby="basic-addon1" value="<?= (old('harga')) ? old('harga') : $produk->harga ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('harga'); ?>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Stok</span>
                            <input type="number" class="form-control <?= ($validation->hasError('stok')) ? 'is-invalid' : '' ?>" placeholder="Stok" aria-label="stok" name="stok" id="stok" aria-describedby="basic-addon1" value="<?= (old('stok')) ? old('stok') : $produk->stok ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('harga'); ?>
                            </div>
                        </div>
                        <label for="gambar">Gambar tidak wajib di ubah</label>
                        <div class="input-group mb-3">
                            <input type="file" id="gambar" name="gambar" class="form-control-file <?= ($validation->hasError('gambar')) ? 'is-invalid' : '' ?>" onchange="profilpreview()">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal
                            </button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </center>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>