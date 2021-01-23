<?= $this->extend('mypanel/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">

            <!-- Page Heading -->
            <center>
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top rounded-circle" src="<?= base_url() ?>/img/profile/<?= user()->user_image; ?>" alt="Card image cap">
                    <div class="card-body">
                        <h3 class="card-title"><b><?= user()->fullname; ?></b></h3>
                        <h5 class="card-title"><i>@<?= user()->username; ?></i></h5>
                        <form action="<?= base_url('admin/ubahdata') ?>" class="d-inline" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btnhilang">
                                <span class="iconify" data-icon="clarity:edit-line" data-inline="false" style="color: dodgerblue;" data-width="45" data-height="45" data-flip="horizontal"></span>
                            </button>
                        </form>
                        <?php if (user()->whatsapp != null) : ?>
                            <form action="<?= base_url('admin/ubahpassword') ?>" class="d-inline" method="post">
                                <?= csrf_field() ?>
                                <button type="submit" class="btnhilang">
                                    <span class="iconify" data-icon="carbon:password" data-inline="false" style="color: forestgreen;" data-width="45" data-height="45"></span>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>