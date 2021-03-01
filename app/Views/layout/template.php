<!DOCTYPE html>
<html lang="en-US" itemscope="itemscope" itemtype="http://schema.org/WebPage">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/bootstrap-grid.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/bootstrap-reboot.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/slick.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/slick-style.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/style.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/colors/blue.css" media="all" />
    <link href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/gua.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,900" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url(); ?>/tokolancer.ico">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/swal2/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/css/tombol-buka-tutup.css">
    <title><?= $judul; ?></title>
</head>

<body class="woocommerce-active page-template-template-homepage-v12">
    <div id="page" class="hfeed site">
        <!-- .top-bar-v2 -->
        <header id="masthead" class="site-header header-v10" style="background-image: none; ">
            <?= $this->include('layout/max') ?>
            <!-- .col-full -->
            <!-- .col-full -->
            <?= $this->include('layout/mini') ?>
            <!-- .handheld-only -->
        </header>

        <!-- .header-v10 -->
        <!-- ============================================================= Header End ============================================================= -->
        <div id="content" class="site-content">
            <?= $this->renderSection('content'); ?>
            <!-- .col-full -->
            <div class="modal fade" id="namaModal" tabindex="-1" aria-labelledby="namaModalLabel" aria-hidden="true" style="z-index: 99999999999;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <center>
                                <div class="card w-75">
                                    <div class="card-body">
                                        <h5 class="card-title">Ooops !</h5>
                                        <p class="card-text">Akun anda belum mempunyai nama</p>
                                        <hr>
                                        <p>Demi kenyamanan transaksi silahkan ubah nama anda dulu di pengaturan profile.</p>
                                        <a href="<?= base_url('/user/profile') ?>">
                                            <button class="btn btn-success">Ubah Nama</button>
                                        </a>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #content -->
        <?= $this->include('layout/footer') ?>
        <!-- .site-footer -->
    </div>
    <?= $this->include('layout/script') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/tether.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/jquery-migrate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/hidemaxlistitem.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/hidemaxlistitem.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/jquery.easing.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/scrollup.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/jquery.waypoints.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/waypoints-sticky.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/pace.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/scripts.js"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/swal2/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/swal2/swall.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/abunaum/naum-market-css-js@master/js/tombol-buka-tutup-rev-1.js"></script>

    <?php if (logged_in('true')) : ?>
        <?php if ($_SERVER['REQUEST_URI'] != '/user/profile') : ?>
            <?php
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            $builder->where('id', user()->id);
            $useryanglogin = $builder->get()->getFirstRow();
            ?>
            <?php if ($useryanglogin->fullname == 'Unknown User') : ?>
                <script>
                    $('#namaModal').modal('show');
                </script>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>