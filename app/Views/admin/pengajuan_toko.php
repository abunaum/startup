<?= $this->extend('mypanel/template'); ?>
<?= $this->section('content'); ?>
<!-- Begin Page Content -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <div class="container-fluid">

            <!-- Page Heading -->
            <center>
                <h1>Pengajuan Toko</h1>
                <div style="overflow-x:auto;">
                    <table class="table table-striped">
                        <thead>
                            <td>#</td>
                            <td>Username</td>
                            <td>Pemilik</td>
                            <td>Detail</td>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($user as $user) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <?php
                                    $db = \Config\Database::connect();
                                    $toko = $db->table('toko');
                                    $toko->where('username_user', $user->username);
                                    $toko = $toko->get()->getFirstRow();
                                    ?>
                                    <td><?= $toko->username; ?></td>
                                    <td><?= $user->fullname; ?></td>
                                    <td>
                                        <div class="row">
                                            <form class="col-2" action="<?= base_url('admin/toko/detail') . '/' . $toko->id; ?>" method="post">
                                                <button type="submit" class="btnhilang">
                                                    <span class="iconify" data-icon="mdi:card-account-details-outline" data-inline="false" style="color: darkgreen;" data-width="24" data-height="24"></span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?= $pager->links(); ?>
            </center>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>