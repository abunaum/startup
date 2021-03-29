<div class="col-full desktop-only">
    <div class="techmarket-sticky-wrap">
        <div class="row">
            <div class="site-branding">
                <a href="<?= base_url(); ?>">
                    <img src="<?= base_url(); ?>/logotoko.png" alt="Toko Lancer">
                </a>
                <!-- /.custom-logo-link -->
            </div>
            <!-- /.site-branding -->
            <!-- ============================================================= End Header Logo ============================================================= -->
            <form class="navbar-search" method="post" action="<?= base_url() ?>">
                <label class="sr-only screen-reader-text" for="search">Cari :</label>
                <div class="input-group">
                    <input type="text" id="search" class="form-control search-field product-search-field" dir="ltr" value="" name="search" placeholder="Search for products" />
                    <!-- .input-group-addon -->
                    <div class="input-group-btn input-group-append">
                        <input type="hidden" id="search-param" name="post_type" value="product" />
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i>
                            <span class="search-btn">Cari</span>
                        </button>
                    </div>
                    <!-- .input-group-btn -->
                </div>
                <!-- .input-group -->
            </form>
            <?php if (logged_in('true')) : ?>
                <!-- .navbar-search -->
                <!-- .header-wishlist -->
                <ul class="header-wishlist nav navbar-nav">
                    <li class="nav-item">
                        <a class="cart-contents" href="<?= base_url('user/order/keranjang') ?>">
                            <span class="iconify" data-icon="ic:outline-local-grocery-store" data-inline="false" data-width="24" data-height="24"></span>
                            <?php
                            $keranjang = new \App\Models\Keranjang();
                            $keranjang->where('buyer', user()->id);
                            $totalkeranjang = $keranjang->countAllResults();
                            ?>
                            <?php if ($totalkeranjang >= 1) : ?>
                                <span class="count"><?= $totalkeranjang ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
                <ul class="header-wishlist nav navbar-nav">
                    <li class="nav-item">
                        <a class="cart-contents" href="<?= base_url('toko') ?>">
                            <span class="iconify" data-icon="clarity:store-line" data-inline="false" data-width="24" data-height="24"></span>
                        </a>
                    </li>
                </ul>
                <ul class="header-wishlist nav navbar-nav">
                    <li class="my-account">
                        <a href="#" id="saldoDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="iconify" data-icon="la:clipboard-list" data-inline="false" data-width="24" data-height="24"></span>
                            <?php
                            $invoice = new \App\Models\Invoice();
                            $keranjang = new \App\Models\Keranjang();
                            $getinv = $keranjang->where('buyer', user()->id)->where('status', 1)->onlyDeleted()->groupBy("invoice");
                            $totalinvoice = $getinv->countAllResults();
                            ?>
                            <?php if ($totalinvoice >= 1) : ?>
                                <span class="badge badge-pill badge-danger">
                                    <?= $totalinvoice ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="<?= base_url('user/order/invoice'); ?>">
                                Invoice &nbsp;
                                <?php if ($totalinvoice >= 1) : ?>
                                    <span class="badge badge-pill badge-danger">
                                        <?= $totalinvoice ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                            <a class="dropdown-item" href="<?= base_url(); ?>">
                                Riwayat Transaksi
                            </a>
                        </div>
                    </li>
                </ul>
                <ul class="header-wishlist nav navbar-nav">
                    <li class="nav-item">
                        <a class="cart-contents" href="<?= base_url('user/notifikasi') ?>">
                            <span class="iconify" data-icon="ic:outline-notifications-active" data-inline="false" data-width="24" data-height="24"></span>
                        </a>
                    </li>
                </ul>
                <ul class="header-wishlist nav navbar-nav">
                    <li class="my-account">
                        <a href="#" id="saldoDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="iconify" data-icon="dashicons:money-alt" data-inline="false" data-width="24" data-height="24"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="<?= base_url('user/saldo'); ?>">
                                Cek Saldo
                            </a>
                            <a class="dropdown-item" href="<?= base_url('user/saldo/topup'); ?>">
                                Riwayat Topup
                            </a>
                        </div>
                    </li>
                </ul>
                <ul class="header-wishlist nav navbar-nav">
                    <li class="my-account">
                        <a href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?= base_url() ?>/img/profile/<?= user()->user_image; ?>" width="30" height="30" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="<?= base_url('user/profile'); ?>">
                                Profile
                            </a>
                            <a class="dropdown-item" href="<?= base_url('logout'); ?>">
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
                <!-- .site-header-cart -->
            <?php else : ?>
                <ul class="header-compare nav navbar-nav">
                    <li class="nav-item">
                        <a href="<?= base_url('login') ?>" class="has-icon">
                            <span class="iconify" data-icon="ant-design:login-outlined" data-inline="false" data-width="24" data-height="24"></span>
                            <span class="value">Login / Register </span>
                        </a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.techmarket-sticky-wrap -->
    <div class="stretched-row">
        <div class="col-full">
            <div class="row">
                <?= $this->include('layout/navbar') ?>
            </div>
            <!-- .row -->
        </div>
        <!-- .col-full -->
    </div>
    <!-- .stretched-row -->
</div>