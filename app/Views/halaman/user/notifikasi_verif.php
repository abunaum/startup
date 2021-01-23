<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<section class="stretch-full-width">
    <div class="col-full">
        <div class="swall" data-swall="<?= session()->getFlashdata('pesan'); ?>"></div>
        <div class="error" data-error="<?= session()->getFlashdata('error'); ?>"></div>
        <div class="container-fluid">

            <!-- Page Heading -->
            <center>
                <h1>Konfirmasi Kode Whatsapp</h1>
                <div class="card" style="width: 30rem;">
                    <form class="g-3 needs-validation mt-3" action="<?= base_url('user/notifikasi/verifwa'); ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <h3>Nomor whatsapp anda <?= $wa; ?></h3>
                                <input type="text" class="form-control <?= ($validation->hasError('kode')) ? 'is-invalid' : '' ?>" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" aria-label="kode" name="kode" id="kode" aria-describedby="basic-addon1" value="<?= old('kode') ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('kode'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#waModal">Ubah nomor</a>
                            <a href="<?= base_url('user/notifikasi/kirimwhatsappulang') ?>" class="btn btn-warning">Kirim ulang kode</a>
                            <button type="submit" class="btn btn-primary">Konfirmasi</button>
                        </div>
                    </form>
                </div>
            </center>
            <div class="modal fade" id="waModal" tabindex="-1" aria-labelledby="waModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="waModalLabel">Ubah nomor Whatsapp</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <center>
                                <form class="row g-3 needs-validation" action="<?= base_url('user/notifikasi/ubahwa'); ?>" method="post" novalidate>
                                    <?= csrf_field() ?>
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">+62</span>
                                            <input type="number" class="form-control <?= ($validation->hasError('wa')) ? 'is-invalid' : '' ?>" placeholder="821xxxxxxxx" aria-label="wa" name="wa" id="wa" aria-describedby="basic-addon1" value="<?= old('wa') ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('wa'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                                    </div>
                                </form>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .col-full -->
</section>
<?= $this->endSection(); ?>