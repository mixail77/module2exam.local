<?php

use Tamtamchik\SimpleFlash\Flash;

//Шаблон
$this->layout('layout', [
    'title' => 'Удалить пользователя',
]);

?>

<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-lock'></i> Удалить пользователя
        </h1>
    </div>
    <?= Flash::display() ?>
</main>
