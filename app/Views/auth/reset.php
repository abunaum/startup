<?= $this->extend('auth/template'); ?>
<?= $this->section('content'); ?>
<div class="page-wrapper">
    <div class="page-content--bge5">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-form">
                        <center>
                            <h2 class="card-header"><?= lang('Auth.resetYourPassword') ?></h2>
                        </center>
                        <div class="card-body">

                            <?= view('Myth\Auth\Views\_message_block') ?>

                            <p><?= lang('Auth.enterCodeEmailPassword') ?></p>

                            <form action="<?= route_to('reset-password') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <input type="text" class="form-control <?php if (session('errors.token')) : ?>is-invalid<?php endif ?>" name="token" placeholder="<?= lang('Auth.token') ?>" value="<?= old('token', $token ?? '') ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.token') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.email') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" name="password" placeholder="Password baru">
                                    <div class="invalid-feedback">
                                        <?= session('errors.password') ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" name="pass_confirm" placeholder="Ulangi password baru">
                                    <div class="invalid-feedback">
                                        <?= session('errors.pass_confirm') ?>
                                    </div>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.resetPassword') ?></button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>