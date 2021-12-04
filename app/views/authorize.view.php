<?php

use Tamtamchik\SimpleFlash\Flash;

//Шаблон
$this->layout('layout', [
    'title' => 'Авторизация',
    'page' => 'authorize',
]);

?>

<div class="blankpage-form-field">
    <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
            <img src="<?= $this->asset('/assets/img/logo.png') ?>" alt="SmartAdmin WebApp" aria-roledescription="logo">
            <span class="page-logo-text mr-1">Учебный проект</span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
        <?= Flash::display() ?>
        <form action="/" method="post">
            <div class="form-group">
                <label class="form-label" for="email">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="E-mail" value="">
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Пароль</label>
                <input type="password" id="password" class="form-control" placeholder="Пароль">
            </div>
            <div class="form-group text-left">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="remember">
                    <label class="custom-control-label" for="remember">Запомнить меня</label>
                </div>
            </div>
            <button type="submit" class="btn btn-default float-right">Войти</button>
        </form>
    </div>
    <div class="blankpage-footer text-center">
        Нет аккаунта? <a href="/register/"><strong>Зарегистрироваться</strong>
    </div>
</div>
<video poster="<?= $this->asset('/assets/img/backgrounds/clouds.png') ?>" id="bgvid" playsinline autoplay muted loop>
    <source src="<?= $this->asset('/assets/media/video/cc.webm') ?>" type="video/webm">
    <source src="<?= $this->asset('/assets/media/video/cc.mp4') ?>" type="video/mp4">
</video>