<?= $this->extend('auth/template'); ?>
<?= $this->section('content'); ?>
<div class="page-wrapper">
    <div class="page-content--bge5">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <a href="#">
                            <img src="<?= base_url(); ?>/logotoko.png" alt="Toko Lancer">
                        </a>
                    </div>
                    <div class="login-form">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><?= lang('Auth.register') ?></h1>
                        </div>
                        <?php
                        //echo view('Myth\Auth\Views\_message_block') 
                        ?>
                        <form action="<?= route_to('register') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="form-group">
                                <?php if (session('errors.username')) : ?>
                                    <?= session('errors.username'); ?>
                                <?php endif; ?>
                                <input type="text" class="au-input au-input--full form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                            </div>

                            <div class="form-group">
                                <?php if (session('errors.email')) : ?>
                                    <?= session('errors.email'); ?>
                                <?php endif; ?>
                                <input type="email" class="au-input au-input--full form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required />
                            </div>
                            <div class="form-group">
                                <?php if (session('errors.password')) : ?>
                                    <?= session('errors.password'); ?>
                                <?php endif; ?>
                                <input type="password" name="password" class="au-input au-input--full form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <?php if (session('errors.pass_confirm')) : ?>
                                    <?= session('errors.pass_confirm'); ?>
                                <?php endif; ?>
                                <input type="password" name="pass_confirm" class="au-input au-input--full form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary btn-user btn-block"><?= lang('Auth.register') ?>
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="<?= route_to('login') ?>"><?= lang('Auth.alreadyRegistered') ?> <?= lang('Auth.signIn') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>