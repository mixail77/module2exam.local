<?php

use Tamtamchik\SimpleFlash\Flash;

//Шаблон
$this->layout('layout', [
    'title' => 'Ошибка 404. Нет такой страницы',
    'page' => 'Ошибка 404. Нет такой страницы',
]);

?>

<?= Flash::display() ?>
