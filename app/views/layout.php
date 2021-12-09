<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $this->e($title) ?></title>
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- ios devices on Windows Phone IE -->
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print"
          href="<?= $this->asset('/assets/css/vendors.bundle.css') ?>">
    <link id="appbundle" rel="stylesheet" media="screen, print"
          href="<?= $this->asset('/assets/css/app.bundle.css') ?>">
    <link id="myskin" rel="stylesheet" media="screen, print" href="<?= $this->asset('/assets/css/skin-master.css') ?>">
    <!-- favicon.ico -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $this->asset('/assets/img/favicon/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $this->asset('/assets/img/favicon/favicon-32x32.png') ?>">
    <link rel="mask-icon" href="<?= $this->asset('/assets/img/favicon/safari-pinned-tab.svg') ?>" color="#5bbad5">
    <? if ($page): ?>
        <link rel="stylesheet" media="screen, print" href="<?= $this->asset('/assets/css/page-login-alt.css') ?>">
    <? endif; ?>
    <link rel="stylesheet" media="screen, print" href="<?= $this->asset('/assets/css/fa-solid.css') ?>">
    <link rel="stylesheet" media="screen, print" href="<?= $this->asset('/assets/css/fa-brands.css') ?>">
    <link rel="stylesheet" media="screen, print" href="<?= $this->asset('/assets/css/fa-regular.css') ?>">
    <script src="<?= $this->asset('/assets/js/jquery-3.6.0.js') ?>"></script>
</head>
<body>

<? if (!$page): ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
        <a class="navbar-brand d-flex align-items-center fw-500" href="/">
            <img alt="logo" class="d-inline-block align-top mr-2" src="<?= $this->asset('/assets/img/logo.png') ?>">
            Учебный проект
        </a>
        <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation"
                class="navbar-toggler" data-target="#navbarColor02" data-toggle="collapse" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Главная
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/logout/">Выйти</a>
                </li>
            </ul>
        </div>
    </nav>
<? endif; ?>

<?= $this->section('content') ?>

</body>
</html>
