<?php

use Tamtamchik\SimpleFlash\Flash;

//Шаблон
$this->layout('layout', [
    'title' => 'Установить статус',
]);

?>

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-sun'></i> Установить статус
        </h1>
    </div>
    <?= Flash::display() ?>
    <form action="/profile/<?= $this->e($user_id) ?>/status/" method="post">
        <input type="hidden" name="profile_id" value="<?= $profile['id'] ?>">
        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Установка текущего статуса</h2>
                        </div>
                        <div class="panel-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="example-select">Выберите статус</label>
                                        <select class="form-control" id="example-select" name="status_id">
                                            <? foreach($status as $value): ?>
                                                <option value="<?= $value['id'] ?>" <?=($value['id'] == $profile['status_id']) ? 'selected' : ''?>><?= $value['name'] ?></option>
                                            <? endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                                    <button class="btn btn-warning">Установить</button>
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