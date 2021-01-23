<!DOCTYPE html>
<html lang="en-US" itemscope="itemscope" itemtype="http://schema.org/WebPage">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/bootstrap.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/bootstrap-grid.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/bootstrap-reboot.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/font-techmarket.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/slick.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/techmarket-font-awesome.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/slick-style.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/animate.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/style.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/colors/blue.css" media="all" />
    <link href="<?= base_url(); ?>/assets/css/gua.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,900" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url(); ?>/tokolancer.ico">

    <link rel="stylesheet" href="<?= base_url(); ?>/assets/js/swal2/sweetalert2.min.css">
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
        </div>
        <!-- #content -->
        <?= $this->include('layout/footer') ?>
        <!-- .site-footer -->
    </div>
    <?= $this->include('layout/script') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="<?= base_url(); ?>/assets/js/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/tether.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/jquery-migrate.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/hidemaxlistitem.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/jquery-ui.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/hidemaxlistitem.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/jquery.easing.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/scrollup.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/jquery.waypoints.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/waypoints-sticky.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/pace.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/slick.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/scripts.js"></script>
    <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/swal2/sweetalert2.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/swal2/swall.js"></script>

</body>

</html>