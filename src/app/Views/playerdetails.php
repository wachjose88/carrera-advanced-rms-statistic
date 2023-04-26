<div class="container">
    <h1><?= esc($title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.image') ?></h5>
                <div class="card-body">
                    <?php if (!is_null($image)): ?>
                        <img src="<?= base_url('uploads/players/' . esc($image)) ?>" alt="<?= esc($title) ?>" class="img-fluid">
                        <br><br><a href="<?= base_url('players/delete/' . esc($player['id'])) ?>" class="btn btn-primary">
                            <?= lang('carrera.delete') ?>
                        </a>
                    <?php else: ?>
                        <form method="post" action="<?= base_url('players/details/' . esc($player['id'])) ?>" enctype="multipart/form-data">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger">
                                    <?= esc($error) ?>
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <input type="file" name="file" class="form-control">
                            </div><br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"><?= lang('carrera.upload') ?></button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.details') ?></h5>
                <div class="card-body">
                    <ul>
                        <li><?= lang('carrera.numplayertrainings') ?>:
                            <?= esc($wins['trainingwins']) ?>/<?= esc($wins['trainings']) ?></li>
                        <li><?= lang('carrera.numplayerqualifyings') ?>:
                            <?= esc($wins['qualifyingwins']) ?>/<?= esc($wins['qualifyings']) ?></li>
                        <li><?= lang('carrera.numplayerraces') ?>:
                            <?= esc($wins['racewins']) ?>/<?= esc($wins['races']) ?></li>
                        <li><?= lang('carrera.laps') ?>:
                            <?= esc($statistic['laps']) ?></li>
                        <li><?= lang('carrera.bestlap') ?>:
                            <?= esc($statistic['bestlap']) ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.trainings') ?></h5>
                <div class="card-body">
                    <canvas id="trainings_chart"></canvas>
                </div>
                <table class="table">
                    <tr>
                        <th><?= lang('carrera.comptitle') ?></th>
                        <th><?= lang('carrera.compdate') ?></th>
                    </tr>
                    <?php foreach($wins['competition_trainings'] as $comp): ?>
                        <tr>
                            <td>
                                <a href="<?= base_url('index.php/results/details/' . esc($comp['id'])) ?>">
                                    <?php if (! empty($comp['title'])) : ?>
                                        <?= esc($comp['title']) ?>
                                    <?php else : ?>
                                        <?= lang('carrera.compnotitle') ?>
                                    <?php endif ?>
                                </a>
                            </td>
                            <td><?= esc($comp['time']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.qualifyings') ?></h5>
                <div class="card-body">
                    <canvas id="qualifyings_chart"></canvas>
                </div>
                <table class="table">
                    <tr>
                        <th><?= lang('carrera.comptitle') ?></th>
                        <th><?= lang('carrera.compdate') ?></th>
                    </tr>
                    <?php foreach($wins['competition_qualifyings'] as $comp): ?>
                        <tr>
                            <td>
                                <a href="<?= base_url('index.php/results/details/' . esc($comp['id'])) ?>">
                                    <?php if (! empty($comp['title'])) : ?>
                                        <?= esc($comp['title']) ?>
                                    <?php else : ?>
                                        <?= lang('carrera.compnotitle') ?>
                                    <?php endif ?>
                                </a>
                            </td>
                            <td><?= esc($comp['time']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header"><?= lang('carrera.races') ?></h5>
                <div class="card-body">
                    <canvas id="races_chart"></canvas>
                </div>
                <table class="table">
                    <tr>
                        <th><?= lang('carrera.comptitle') ?></th>
                        <th><?= lang('carrera.compdate') ?></th>
                    </tr>
                    <?php foreach($wins['competition_races'] as $comp): ?>
                        <tr>
                            <td>
                                <a href="<?= base_url('index.php/results/details/' . esc($comp['id'])) ?>">
                                    <?php if (! empty($comp['title'])) : ?>
                                        <?= esc($comp['title']) ?>
                                    <?php else : ?>
                                        <?= lang('carrera.compnotitle') ?>
                                    <?php endif ?>
                                </a>
                            </td>
                            <td><?= esc($comp['time']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <script>
        var ctx = document.getElementById('trainings_chart');
        var cChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['<?= lang('carrera.wins') ?>',
                    '<?= lang('carrera.trainings') ?>'],
                datasets: [{
                    data: [<?= $wins['trainingwins'] ?>, <?= $wins['trainings'] ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: false
                    }
                }

            }
        });
        var ctx1 = document.getElementById('qualifyings_chart');
        var cChart1 = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['<?= lang('carrera.wins') ?>',
                    '<?= lang('carrera.qualifyings') ?>'],
                datasets: [{
                    data: [<?= $wins['qualifyingwins'] ?>, <?= $wins['qualifyings'] ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: false
                    }
                }

            }
        });
        var ctx2 = document.getElementById('races_chart');
        var cChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['<?= lang('carrera.wins') ?>',
                    '<?= lang('carrera.races') ?>'],
                datasets: [{
                    data: [<?= $wins['racewins'] ?>, <?= $wins['races'] ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: false
                    }
                }

            }
        });
    </script>
</div>