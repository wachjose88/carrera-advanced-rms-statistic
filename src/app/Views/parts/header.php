<!doctype html>
<html lang="en">
  <?php $globals = \App\Controllers\BaseController::getGlobals(); ?>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="<?= base_url('css/bootstrap.min.css') ?>" rel="stylesheet">
      <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">

    <title><?= $title ?> - <?= $globals['sitetitle'] ?> - <?= lang('carrera.title') ?></title>
  </head>
  <body>
  <script src="<?= base_url('js/chart.js') ?>"></script>
  <nav class="navbar navbar-expand-lg  navbar-dark bg-primary">
      <div class="container-fluid">
          <a class="navbar-brand" href="<?= base_url('index.php/home') ?>">
              <?= lang('carrera.title') ?>: <?= $globals['sitetitle'] ?></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                  data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                  aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                  <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('home') ?>">
                          <?= lang('carrera.home') ?></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('results') ?>">
                          <?= lang('carrera.results') ?></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('championship') ?>">
                          <?= lang('carrera.championship') ?></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('players') ?>">
                          <?= lang('carrera.players') ?></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('cars') ?>">
                          <?= lang('carrera.cars') ?></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="<?= base_url('config') ?>">
                          <?= lang('carrera.config') ?></a>
                  </li>
              </ul>
          </div>
      </div>
  </nav>
