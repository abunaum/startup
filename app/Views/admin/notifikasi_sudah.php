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
                <div class="card w-75">
                    <div class="card-body">
                        <h5 class="card-title">Mantap</h5>
                        <p class="card-text">Notifikasi terhubung ke nomor whatsapp <?= user()->whatsapp ?></p>
                        <button type="button" class="btn btn-danger mb-3" data-toggle="modal" data-target="#waModal">
                            Ubah Nomor
                        </button>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>
<div class="modal fade" id="waModal" tabindex="-1" aria-labelledby="waModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="waModalLabel">Ubah nomor Whatsapp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <form class="row g-3 needs-validation" action="<?= base_url('admin/ubahwa'); ?>" method="post" novalidate>
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
<!-- /.container-fluid -->
<?= $this->endSection(); ?>