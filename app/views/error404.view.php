<?php

use Tamtamchik\SimpleFlash\Flash;

//Шаблон
$this->layout('layout', [
    'title' => '404 Not Found',
    'page' => '404 Not Found',
]);

?>

<?= Flash::display() ?>
