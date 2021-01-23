<?= $this->extend('auth/template'); ?>
<?= $this->section('content'); ?>
<div class="container">

    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-form">
                            <div class="text-center">
                                <h2 class="card-header"><?= lang('Auth.forgotPassword') ?></h2>
                            </div>
                            <?= view('Myth\Auth\Views\_message_block') ?>
                            <p><?= lang('Auth.enterEmailForInstructions') ?></p>
                            <form class="user" action="<?= route_to('forgot') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user <<?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.email') ?>
                                    </div>
                                </div>
                                <hr>
                                <center>
                                    <button type="submit" class="btn btn-primary btn-user">
                                        <?= lang('Auth.sendInstructions') ?>
                                    </button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>