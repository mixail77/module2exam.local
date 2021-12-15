<?php

use Tamtamchik\SimpleFlash\Flash;

//Шаблон
$this->layout('layout', [
    'title' => 'Добавить пользователя',
]);

?>

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title"><i class='subheader-icon fal fa-plus-circle'></i> Добавить пользователя</h1>
    </div>
    <?= Flash::display() ?>
    <form action="/create/" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Общая информация</h2>
                        </div>
                        <div class="panel-content">
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Имя</label>
                                <input type="text" name="name" id="simpleinput" class="form-control" value="<?= $profile['name'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Место работы</label>
                                <input type="text" name="job" id="simpleinput" class="form-control" value="<?= $profile['job'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Номер телефона</label>
                                <input type="text" name="phone" id="simpleinput" class="form-control" value="<?= $profile['phone'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Адрес</label>
                                <input type="text" name="address" id="simpleinput" class="form-control" value="<?= $profile['address'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Безопасность и Медиа</h2>
                        </div>
                        <div class="panel-content">
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Email</label>
                                <input type="text" name="email" id="simpleinput" class="form-control" value="<?= $profile['email'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Пароль</label>
                                <input type="password" name="password" id="simpleinput" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="example-select">Выберите статус</label>
                                <select class="form-control" id="example-select" name="status">
                                    <? foreach($status as $value): ?>
                                        <option value="<?= $value['id'] ?>" <?=($value['id'] == $profile['status']) ? 'selected' : ''?>><?= $value['info'] ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="example-fileinput">Загрузить аватар</label>
                                <input type="file" name="photo" id="example-fileinput" class="form-control-file">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Социальные сети</h2>
                        </div>
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group input-group-lg bg-white shadow-inset-2 mb-2">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                                    <span class="icon-stack fs-xxl">
                                                        <i class="base-7 icon-stack-3x" style="color:#4680C2"></i>
                                                        <i class="fab fa-vk icon-stack-1x text-white"></i>
                                                    </span>
                                                </span>
                                        </div>
                                        <input type="text" name="vk" class="form-control border-left-0 bg-transparent pl-0" value="<?= $profile['vk'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-lg bg-white shadow-inset-2 mb-2">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                                    <span class="icon-stack fs-xxl">
                                                        <i class="base-7 icon-stack-3x" style="color:#38A1F3"></i>
                                                        <i class="fab fa-telegram icon-stack-1x text-white"></i>
                                                    </span>
                                                </span>
                                        </div>
                                        <input type="text" name="telegram" class="form-control border-left-0 bg-transparent pl-0" value="<?= $profile['telegram'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-lg bg-white shadow-inset-2 mb-2">
                                        <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent border-right-0 py-1 px-3">
                                                    <span class="icon-stack fs-xxl">
                                                        <i class="base-7 icon-stack-3x" style="color:#E1306C"></i>
                                                        <i class="fab fa-instagram icon-stack-1x text-white"></i>
                                                    </span>
                                                </span>
                                        </div>
                                        <input type="text" name="instagram" class="form-control border-left-0 bg-transparent pl-0" value="<?= $profile['instagram'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-success">Добавить</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </form>
</main>
<script src="<?= $this->asset('/assets/js/vendors.bundle.js') ?>"></script>
<script src="<?= $this->asset('/assets/js/app.bundle.js') ?>"></script>

