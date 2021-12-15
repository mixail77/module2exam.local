<?php

use Tamtamchik\SimpleFlash\Flash;

//Шаблон
$this->layout('layout', [
    'title' => 'Список пользователей',
]);

?>

<main id="js-page-content" role="main" class="page-content mt-3">
    <?= Flash::display() ?>
    <div class="subheader">
        <h1 class="subheader-title"><i class='subheader-icon fal fa-users'></i> Список пользователей</h1>
    </div>
    <div class="row">
        <div class="col-xl-12">

            <? if($auth->isAdmin()): ?>
                <a class="btn btn-success" href="/create/">Добавить</a>
            <? endif; ?>

            <div class="border-faded bg-faded p-3 mb-g d-flex mt-3">
                <input type="text" id="js-filter-contacts" name="filter-contacts"
                       class="form-control shadow-inset-2 form-control-lg" placeholder="Найти пользователя">
                <div class="btn-group btn-group-lg btn-group-toggle hidden-lg-down ml-3" data-toggle="buttons">
                    <label class="btn btn-default active">
                        <input type="radio" name="contactview" id="grid" checked="" value="grid">
                        <i class="fas fa-table"></i>
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="contactview" id="table" value="table"><i class="fas fa-th-list"></i>
                    </label>
                </div>
            </div>

        </div>
    </div>
    <div class="row" id="js-contacts">

        <? if(!empty($users)): ?>

            <? foreach ($users as $user): ?>

                <div class="col-xl-4">
                    <div id="c_<?= $user['id'] ?>" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="<?= $user['name'] ?>">
                        <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                            <div class="d-flex flex-row align-items-center">

                            <span class="status status-<?= $user['code'] ?> mr-3">
                                <span class="rounded-circle profile-image d-block"
                                      style="background-image:url(<?= ($user['photo']) ? $user['photo'] : $this->asset('/assets/img/logo.png') ?>); background-size: cover;"></span>
                            </span>

                                <div class="info-card-text flex-1">
                                    <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info"
                                       data-toggle="dropdown" aria-expanded="false"><?= $user['name'] ?>
                                        <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                        <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                    </a>

                                    <? if($auth->checkAccessProfile($user['id'])): ?>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="/profile/<?= $user['id'] ?>/"><i class="fa fa-user"></i> Профиль</a>
                                            <a class="dropdown-item" href="/profile/<?= $user['id'] ?>/edit/"><i class="fa fa-edit"></i>Редактировать</a>
                                            <a class="dropdown-item" href="/profile/<?= $user['id'] ?>/security/"><i class="fa fa-lock"></i>Безопасность</a>
                                            <a class="dropdown-item" href="/profile/<?= $user['id'] ?>/status/"><i class="fa fa-sun"></i>Установить статус</a>
                                            <a class="dropdown-item" href="/profile/<?= $user['id'] ?>/media/"><i class="fa fa-camera"></i>Загрузить аватар</a>
                                            <a href="/profile/<?= $user['id'] ?>/delete/" class="dropdown-item" onclick="return confirm('Подтверждаете удаление?');"><i class="fa fa-window-close"></i>Удалить</a>
                                        </div>
                                    <? endif; ?>

                                    <? if(!empty($user['job'])): ?>
                                        <span class="text-truncate text-truncate-xl"><?= $user['job'] ?></span>
                                    <? endif; ?>

                                </div>

                                <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse"
                                        data-target="#c_<?= $user['id'] ?> > .card-body + .card-body" aria-expanded="false">
                                    <span class="collapsed-hidden">+</span>
                                    <span class="collapsed-reveal">-</span>
                                </button>

                            </div>
                        </div>
                        <div class="card-body p-0 collapse show">
                            <div class="p-3">

                                <? if(!empty($user['phone'])): ?>
                                    <a href="tel:+<?= $user['phone'] ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                        <i class="fas fa-mobile-alt text-muted mr-2"></i> <?= $user['phone'] ?>
                                    </a>
                                <? endif; ?>

                                <? if(!empty($user['email'])): ?>
                                    <a href="mailto:<?= $user['email'] ?>"
                                       class="mt-1 d-block fs-sm fw-400 text-dark">
                                        <i class="fas fa-mouse-pointer text-muted mr-2"></i> <?= $user['email'] ?>
                                    </a>
                                <? endif; ?>

                                <? if(!empty($user['address'])): ?>
                                    <address class="fs-sm fw-400 mt-4 text-muted">
                                        <i class="fas fa-map-pin mr-2"></i> <?= $user['address'] ?>
                                    </address>
                                <? endif; ?>

                                <div class="d-flex flex-row">

                                    <? if(!empty($user['vk'])): ?>
                                        <a href="<?= $user['vk'] ?>" class="mr-2 fs-xxl" style="color:#4680C2">
                                            <i class="fab fa-vk"></i>
                                        </a>
                                    <? endif; ?>

                                    <? if(!empty($user['telegram'])): ?>
                                        <a href="<?= $user['telegram'] ?>" class="mr-2 fs-xxl" style="color:#38A1F3">
                                            <i class="fab fa-telegram"></i>
                                        </a>
                                    <? endif; ?>

                                    <? if(!empty($user['instagram'])): ?>
                                        <a href="<?= $user['instagram'] ?>" class="mr-2 fs-xxl" style="color:#E1306C">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    <? endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <? endforeach; ?>

        <? endif; ?>

    </div>
</main>
<script src="<?= $this->asset('/assets/js/vendors.bundle.js') ?>"></script>
<script src="<?= $this->asset('/assets/js/app.bundle.js') ?>"></script>
<script>
    $(document).ready(function () {
        $('input[type=radio][name=contactview]').change(function () {
            if (this.value == 'grid') {
                $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                $('#js-contacts .js-expand-btn').addClass('d-none');
                $('#js-contacts .card-body + .card-body').addClass('show');

            } else if (this.value == 'table') {
                $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                $('#js-contacts .js-expand-btn').removeClass('d-none');
                $('#js-contacts .card-body + .card-body').removeClass('show');
            }
        });
        initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
    });
</script>
