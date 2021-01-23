<?= $this->extend('auth/template'); ?>
<?= $this->section('content'); ?>

<div class="page-wrapper">
    <div class="page-content--bge5">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <a href="<?= base_url('login'); ?>">
                            <img src="<?= base_url(); ?>/logotoko.png" alt="Toko Lancer">
                        </a>
                    </div>
                    <div class="login-form">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><?= lang('Auth.loginTitle') ?></h1>
                        </div>
                        <?= view('Myth\Auth\Views\_message_block') ?>
                        <form class="user" action="<?= route_to('login') ?>" method="post">
                            <?= csrf_field() ?>
                            <?php if ($config->validFields === ['email']) : ?>
                                <div class="form-group">
                                    <input type="email" class="au-input au-input--full <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.email') ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.login') ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="form-group">
                                    <input type="text" class="au-input au-input--full <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>">
                                    <div class="invalid-feedback">
                                        <?= session('errors.login') ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <input type="password" name="password" class="au-input au-input--full <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>">
                                <div class="invalid-feedback">
                                    <?= session('errors.password') ?>
                                </div>
                            </div>
                            <hr>
                            <?php if ($config->allowRemembering) : ?>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" <?php if (old('remember')) : ?> checked <?php endif ?>>
                                        <?= lang('Auth.rememberMe') ?>
                                    </label>
                                </div>
                            <?php endif; ?>
                            <hr>
                            <button type="submit" class="btn btn-primary btn-user btn-block"><?= lang('Auth.loginAction') ?></button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <?php if ($config->activeResetter) : ?>
                                <a class="small" href="<?= route_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="register-link">
                            <h3>
                                <?php if ($config->allowRegistration) : ?>
                                    <a class="small" href="<?= route_to('register') ?>"><?= lang('Auth.needAnAccount') ?> Register</a>
                                <?php endif; ?>
                            </h3>
                        </div>
                        <!-- <div class="register-link">
                            <p>
                                Don't you have account?
                                <a href="#">Sign Up Here</a>
                            </p>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?= $this->endSection(); ?>