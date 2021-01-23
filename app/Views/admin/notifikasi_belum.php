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
                        <h5 class="card-title">Ooops !</h5>
                        <p class="card-text">Nomor Whatsapp belum di konfirmasi.</p>
                        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#tokoModal">
                            Konfirmasi Sekarang
                        </button>
                    </div>
                </div>
            </center>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="tokoModal" tabindex="-1" aria-labelledby="tokoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <center>
                    <h5 class="modal-title" id="tokoModalLabel">Konfirmasi Whatsapp</h5>
                </center>
                <button type="button" class="iconify" data-icon="clarity:window-close-line" data-inline="false" data-width="24px" data-height="24px" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="g-3 needs-validation" action="<?= base_url('admin/notifikasi'); ?>" method="post">
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
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?= $this->endSection(); ?>