<?php

//Шаблон
$this->layout('layout', [
    'title' => 'Профиль пользователя',
]);

?>

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-user'></i> Иван Иванов
        </h1>
    </div>
    <div class="row">
        <div class="col-lg-6 col-xl-6 m-auto">
            <div class="card mb-g rounded-top">
                <div class="row no-gutters row-grid">
                    <div class="col-12">
                        <div class="d-flex flex-column align-items-center justify-content-center p-4">
                            <img src="<?= ($profile['photo']) ? $profile['photo'] : $this->asset('/assets/img/logo.png') ?>"
                                 class="rounded-circle shadow-2 img-thumbnail" alt="">
                            <h5 class="mb-0 fw-700 text-center mt-3">

                                <?= $profile['name'] ?>

                                <? if(!empty($profile['address'])): ?>
                                    <small class="text-muted mb-0"><?= $profile['address'] ?></small>
                                <? endif; ?>

                            </h5>
                            <div class="mt-4 text-center demo">

                                <? if(!empty($profile['instagram'])): ?>
                                    <a href="<?= $profile['instagram'] ?>" class="fs-xl" style="color:#C13584">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                <? endif; ?>

                                <? if(!empty($profile['vk'])): ?>
                                    <a href="<?= $profile['vk'] ?>" class="fs-xl" style="color:#4680C2">
                                        <i class="fab fa-vk"></i>
                                    </a>
                                <? endif; ?>

                                <? if(!empty($profile['telegram'])): ?>
                                    <a href="<?= $profile['telegram'] ?>" class="fs-xl" style="color:#0088cc">
                                        <i class="fab fa-telegram"></i>
                                    </a>
                                <? endif; ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 text-center">

                            <? if(!empty($profile['phone'])): ?>
                                <a href="tel:+<?= $profile['phone'] ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mobile-alt text-muted mr-2"></i> <?= $profile['phone'] ?>
                                </a>
                            <? endif; ?>

                            <? if(!empty($user['email'])): ?>
                                <a href="mailto:<?= $user['email'] ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                    <i class="fas fa-mouse-pointer text-muted mr-2"></i> <?= $user['email'] ?>
                                </a>
                            <? endif; ?>

                            <? if(!empty($profile['address'])): ?>
                                <address class="fs-sm fw-400 mt-4 text-muted">
                                    <i class="fas fa-map-pin mr-2"></i> <?= $profile['address'] ?>
                                </address>
                            <? endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="<?= $this->asset('/assets/js/vendors.bundle.js') ?>"></script>
<script src="<?= $this->asset('/assets/js/app.bundle.js') ?>"></script>

