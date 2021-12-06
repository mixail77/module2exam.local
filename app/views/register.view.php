<?php

use Tamtamchik\SimpleFlash\Flash;

//Шаблон
$this->layout('layout', [
    'title' => 'Регистрация',
    'page' => 'register',
]);

?>

<div class="page-wrapper auth">
    <div class="page-inner bg-brand-gradient">
        <div class="page-content-wrapper bg-transparent m-0">
            <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                <div class="d-flex align-items-center container p-0">
                    <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">
                        <a href="/" class="page-logo-link press-scale-down d-flex align-items-center">
                            <img src="<?= $this->asset('/assets/img/logo.png') ?>" alt="" aria-roledescription="logo">
                            <span class="page-logo-text mr-1">Учебный проект</span>
                        </a>
                    </div>
                    <span class="text-white opacity-50 ml-auto mr-2 hidden-sm-down">
                            Уже зарегистрированы?
                        </span>
                    <a href="/" class="btn-link text-white ml-auto ml-sm-0">
                        Войти
                    </a>
                </div>
            </div>
            <div class="flex-1"
                 style="background: url(<?= $this->asset('/assets/img/svg/pattern-1.svg') ?>) no-repeat center bottom fixed; background-size: cover;">
                <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                    <div class="row">
                        <div class="col-xl-12">
                            <h2 class="fs-xxl fw-500 mt-4 text-white text-center">
                                Регистрация
                                <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60 hidden-sm-down">
                                    E-mail будет вашим логином при авторизации.<br />
                                    На указанный E-mail будет отправлено письмо, содержащее ссылку для активации учетной записи.
                                </small>
                            </h2>
                        </div>
                        <div class="col-xl-6 ml-auto mr-auto">
                            <div class="card p-4 rounded-plus bg-faded">
                                <?= Flash::display() ?>
                                <form id="js-login" novalidate="" action="/register/" method="post">
                                    <div class="form-group">
                                        <label class="form-label" for="emailverify">E-mail</label>
                                        <input type="email" name="email" id="emailverify" class="form-control" value="<?= $this->e($email) ?>" placeholder="E-mail" required>
                                        <div class="invalid-feedback">Заполните поле.</div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="userpassword">Пароль <br></label>
                                        <input type="password" name="password" id="userpassword" class="form-control" value="<?= $this->e($password) ?>" placeholder="Пароль" required>
                                        <div class="invalid-feedback">Заполните поле.</div>
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-md-4 ml-auto text-right">
                                            <button id="js-login-btn" type="submit"
                                                    class="btn btn-block btn-danger btn-lg mt-3">Регистрация
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="<?= $this->asset('/assets/js/vendors.bundle.js') ?>"></script>

