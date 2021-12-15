<?php

use Tamtamchik\SimpleFlash\Flash;

//Шаблон
$this->layout('layout', [
    'title' => 'Редактировать пользователя',
]);

?>

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Редактировать пользователя
        </h1>
    </div>
    <?= Flash::display() ?>
    <form action="/profile/<?= $this->e($user_id) ?>/edit/" method="post">
        <input type="hidden" name="profile_id" value="<?= $profile['id'] ?>">
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
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">vk</label>
                                <input type="text" name="vk" id="simpleinput" class="form-control" value="<?= $profile['vk'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">instagram</label>
                                <input type="text" name="instagram" id="simpleinput" class="form-control" value="<?= $profile['instagram'] ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">telegram</label>
                                <input type="text" name="telegram" id="simpleinput" class="form-control" value="<?= $profile['telegram'] ?>">
                            </div>
                            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                <button class="btn btn-warning">Редактировать</button>
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